<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Carrito;
use App\Entidades\Pedido;
use App\Entidades\Cliente;
use App\Entidades\Pedido_producto;
use App\Entidades\Sucursal;
use Session;

use MercadoPago\Item;
use MercadoPago\MerchantOrder;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\SDK;

class ControladorWebCarrito extends Controller
{
    public function index()
    {
        $id = Session::get("idCliente");
        $carrito = new Carrito();
        $pedido = new Pedido();
        $sucursal = new Sucursal();
        $aPedidos = $pedido->obtenerPorCliente($id);
        $aCarritos = $carrito->obtenerPorCliente($id);
        $aSucursales = $sucursal->obtenerTodos();

        return view("web.carrito", compact("aCarritos", "aPedidos", "aSucursales"));
    }

    public function procesar(Request $request)
    {
        if (isset($_POST["btnEliminar"])) {
            return $this->eliminar($request);
        } else if (isset($_POST["btnComprar"])) {
            return $this->ingresarCompra($request);
        }
    }

    public function ingresarCompra(Request $request) {
    $id = Session::get("idCliente");

    $lstSucursal = $request->input("lstSucursal");
    $lstPago = $request->input("lstMetodoPago");

    if($lstPago == "Mercadopago"){
        return $this->procesarMercadopago($request);
    } else {
        $carrito = new Carrito();
        $pedido = new Pedido();

        $aCarritos = $carrito->obtenerPorCliente($id);
        $total = 0;

            foreach($aCarritos as $item){
                $total += $item->precio * $item->cantidad;
            }
            
        $pedido->fecha = date("Y-m-d");
        $pedido->total = $total;
        $pedido->fk_idsucursal = $lstSucursal;
        $pedido->fk_idcliente = $id;
        $pedido->fk_idestado = 1;
        $pedido->pago = $lstPago;
        $pedido->insertar();

        $pedido_producto = new Pedido_producto();
        foreach($aCarritos as $item){
            $pedido_producto->fk_idproducto = $item->fk_idproducto;
            $pedido_producto->fk_idpedido = $pedido->idpedido;
            $pedido_producto->cantidad = $item->cantidad;
            $pedido_producto->insertar();
        }

        $carrito->eliminarPorCliente($id);
        
        $msg["ESTADO"] = "success";
        $msg["MSG"] = "Te estaremos avisando cuando el pago se haya efectuado!";
        return view("web.carrito", compact("msg"));
        }
    }

    public function procesarMercadopago(Request $request){
        $id = Session::get("idCliente");

        $lstSucursal = $request->input("lstSucursal");
        $lstPago = $request->input("lstMetodoPago");

        $carrito = new Carrito();
        $pedido = new Pedido();

        $aCarritos = $carrito->obtenerPorCliente($id);
        $total = 0;

            foreach($aCarritos as $item){
                $total += $item->precio * $item->cantidad;
            }
        
        // En el método finalizarPedido del controlador se armará la configuración y datos para la transacción:
        $access_token = env('MERCADOPAGO_ACCESS_TOKEN');
        SDK::setClientId(config("payment-methods.mercadopago.client"));
        SDK::setClientSecret(config("payment-methods.mercadopago.secret"));
        SDK::setAccessToken($access_token); //Es el token de la cuenta de MP donde se deposita el dinero
        //Armado del producto 'item'
        $item = new Item();
        $item->id = "1234";
        $item->title = "Compra Web Burger";
        $item->category_id = "products";
        $item->quantity = 1;
        $item->unit_price = $total;
        $item->currency_id = "ARS"; //"COP"

        $preference = new Preference();
        $preference->items = array($item);

        //Datos del comprador
        $cliente = new Cliente();
        $cliente->obtenerPorId($id);

        $payer = new Payer();
        $payer->name = $cliente->nombre;
        $payer->surname = $cliente->apellido;
        $payer->email = $cliente->correo;
        $payer->date_created = date('Y-m-d H:m:s');
        $payer->identification = array(
            "type" => "DNI",
            "number" => $cliente->dni
        );
        $preference->payer = $payer;
        
        $pedido->fecha = date("Y-m-d");
        $pedido->total = $total;
        $pedido->fk_idsucursal = $lstSucursal;
        $pedido->fk_idcliente = $id;
        $pedido->fk_idestado = 5;
        $pedido->pago = $lstPago;
        $pedido->insertar();

        $pedido_producto = new Pedido_producto();
        foreach($aCarritos as $item){
            $pedido_producto->fk_idproducto = $item->fk_idproducto;
            $pedido_producto->fk_idpedido = $pedido->idpedido;
            $pedido_producto->cantidad = $item->cantidad;
            $pedido_producto->insertar();
        }

        $carrito->eliminarPorCliente($id);

        //URL de configuración para indicarle a MP
        // dominio falso con HTTPS solo para pasar la barrera de seguridad de MP
        $preference->back_urls = array(
            "success" => "https://www.mitest.com/mercado-pago/aprobado/" . $pedido->idpedido,
            "pending" => "https://www.mitest.com/mercado-pago/pendiente/" . $pedido->idpedido,
            "failure" => "https://www.mitest.com/mercado-pago/error/" . $pedido->idpedido
        );

        $preference->payment_methods = array("installments" => 6);
        $preference->auto_return = "all";
        $preference->notification_url = '';
        $preference->save(); //Ejecuta la transacción

        if ($preference->init_point == null) {
            echo "<h3>Hubo un error con Mercado Pago. Esta es la respuesta:</h3>";
            echo "<pre>";
            print_r($preference->error); // Acá MP nos va a confesar qué dato no le gustó
            echo "</pre>";
            exit;
        }

        return redirect($preference->init_point);
    }

    public function eliminar(Request $request)
    {   
        $carrito = new Carrito();
        $idCarrito = $request->input("txtCarrito"); 
        $carrito->idcarrito = $idCarrito;
        $carrito->eliminar();
        $msg["ESTADO"] = "success";
        $msg["MSG"] = "Producto eliminado";
        return redirect("/carrito");
    }
}
