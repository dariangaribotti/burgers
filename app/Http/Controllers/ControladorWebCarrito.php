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
        
        //Recibo las cosas que agregue en takeaway
        if(isset($id) && $id != ""){
            $carrito = new Carrito();
            $aCarritos = $carrito->obtenerPorCliente($id);
            return view("web.carrito", compact("aCarritos"));
        }
    }

    public function ingresarCompra(Request $request){
        
    }
}