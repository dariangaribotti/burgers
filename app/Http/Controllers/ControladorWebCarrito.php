<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Carrito;
use App\Entidades\Producto;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;
   

class ControladorWebCarrito extends Controller
{
    public function index()
    {   
        $idCarrito = 1;
        $carrito = new Carrito();
        $aCarritos = $carrito->obtenerPorId($idCarrito);
        $aProductos = $carrito->obtenerProductos($idCarrito);
        return view("web.carrito", compact("aCarritos", "aProductos"));
    }

    public function guardar(Request $request){
        $carrito = new Carrito();
        $carrito->cargarDesdeRequest($request);
        $carrito->guardar();
        return view("web.carrito", compact("carrito"));
    }
}