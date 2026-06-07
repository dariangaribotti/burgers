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
        $aCarritos = $carrito->obtenerPorCliente($id);

        //Recibo las cosas que agregue en takeaway
        if (isset($id) && $id != "") {
            return view("web.carrito", compact("aCarritos", "aPedidos"));
        } else {
            $msg["ESTADO"] = "danger";
            $msg["MSG"] = "Debes iniciar sesión para agregar productos al carrito";
            return view("web.carrito", compact("msg", "aCarritos", "aPedidos"));
        }
    }

    public function procesar(Request $request)
    {
        if (isset($_POST["btnEliminar"])) {
            return $this->eliminar($request);
        } else if (isset($_POST["btnComprar"])) {
            return $this->ingresarCompra($request);
        }
    }

    public function ingresarCompra(Request $request){
        $id = Session::get("idCliente");

        $sucursal = $request->input("lstSucursal");
        $metodoPago = $request->input("lstMetodoPago");

        if($id != ""){
            
        }
    }

    public function eliminar(Request $request)
    {   
        $id = Session::get("idCliente");

        if($id != ""){
            $carrito = new Carrito();
            $idCarrito = $request->input("txtCarrito"); 
            $carrito->idcarrito = $idCarrito;
            $carrito->eliminar();
            $msg["ESTADO"] = "success";
            $msg["MSG"] = "Producto eliminado";
            return redirect("/carrito");
        } else {
            $msg["ESTADO"] = "danger";
            $msg["MSG"] = "Tiene que iniciar sesion para eliminar";
            return view("web.carrito", compact("msg"));
        }
    }
}
