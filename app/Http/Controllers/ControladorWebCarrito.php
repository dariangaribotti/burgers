<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Carrito;
use App\Entidades\Pedido;
use App\Entidades\Producto;
use App\Entidades\Sucursal;
use Session;

class ControladorWebCarrito extends Controller
{
    public function index()
    {
        $id = Session::get("idCliente");
        $carrito = new Carrito();
        $pedido = new Pedido();
        $aPedidos = $pedido->obtenerPorCliente($id);
        $aCarritos = $carrito->obtenerPorCliente($id);

        //Recibo las cosas que agregue en takeaway
        if (isset($id) && $id != "") {
            return view("web.carrito", compact("aCarritos", "aPedidos"));
        } else {
            $msg["ESTADO"] = "danger";
            $msg["MSG"] = "Debes iniciar sesión para agregar productos al carrito";
            return view("web.carrito", compact("msg", "aCarritos", "aPedidos"));
        }
        return view("web.carrito", compact("aCarritos", "aPedidos"));
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
    $descripcion = "";

        foreach($aCarritos as $carrito){
            $total += $carrito->precio * $carrito->cantidad;
            $descripcion .= "Nombre: " . $carrito->nombre . "Cantidad: " . $carrito->cantidad . ", ";
        }
    $pedido->fecha = date("Y-m-d");
    $pedido->descripcion = $descripcion;
    $pedido->nombre = "Compra Web";
    $pedido->total = $total;
    $pedido->fk_idsucursal = $lstSucursal;
    $pedido->fk_idcliente = $id;
    $pedido->fk_idestado = 2;
    $pedido->pago = $lstPago;

    $pedido->insertar();

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
