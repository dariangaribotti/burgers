<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Carrito;
use App\Entidades\Pedido;
use App\Entidades\Producto;

use Session;

class ControladorWebCarrito extends Controller
{
    public function index()
    {
        $id = Session::get("idCliente");
        $carrito = new Carrito();
        $pedido = new Pedido();
        $aPedidos = $pedido->obtenerPorCliente($id);

        //Recibo las cosas que agregue en takeaway
        if (isset($id) && $id != "") {
            $aCarritos = $carrito->obtenerPorCliente($id);
            return view("web.carrito", compact("aCarritos", "aPedidos"));
        } else {
            $msg["ESTADO"] = "danger";
            $msg["MSG"] = "Debes iniciar sesión para agregar productos al carrito";
            return view("web.carrito", compact("msg"));
        }
    }

    public function ingresarCompra(Request $request) {}

    public function eliminar()
    {
        $id = Session::get("idCliente");

        $carrito = new Carrito();
        $aCarritos = $carrito->obtenerPorCliente($id);

        if(isset($_GET["do"]) && $_GET["do"] == "eliminar") {
            $pos = $_GET["pos"];
            $carrito->idcarrito = $aCarritos[$pos]->idproducto;
            $carrito->eliminar();
            $msg["ESTADO"] = "success";
            $msg["MSG"] = "Producto eliminado";
            return view("web.carrito", compact("msg"));
        } else {
            $msg["ESTADO"] = "danger";
            $msg["MSG"] = "Intenta mas tarde";
            return view("web.carrito", compact("msg"));
        }
    }
}
