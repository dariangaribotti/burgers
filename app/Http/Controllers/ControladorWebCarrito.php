<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Carrito;
use App\Entidades\Producto;

use Session;
   
class ControladorWebCarrito extends Controller
{
    public function index()
    {   
        $id = Session::get("idCliente");
        $carrito = new Carrito();
        
        //Recibo las cosas que agregue en takeaway
        if(isset($id) && $id != ""){
            $aCarritos = $carrito->obtenerPorCliente($id);
            return view("web.carrito", compact("aCarritos"));
        } else {
            return view("web.carrito", compact("carrito"));
        }
    }

    public function ingresarCompra(Request $request){
        
    }
}