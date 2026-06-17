<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Carrito;
use App\Entidades\Pedido;
use App\Entidades\Pedido_producto;
use App\Entidades\Sucursal;
use Session;

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

    return redirect("/carrito");
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
