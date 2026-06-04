<?php

namespace App\Http\Controllers;

use App\Entidades\Producto;
use App\Entidades\Categoria;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;
use Session;

class ControladorWebTakeaway extends Controller
{
    public function index()
    {   
        $pg = "takeaway";
        $producto = new Producto();
        $categoria = new Categoria();
        $aProductos = $producto->obtenerPorCategoria();
        $aCategorias = $categoria->obtenerTodos();
        return view("web.takeaway", compact('pg', 'aProductos', 'aCategorias'));
    }

    public function ingresar(Request $Request){
        $id = Session::get("idCliente");
        
        $producto = new Producto();
        $producto->idproducto = $Request->input("txtIdProducto");
        
        if($id )


        return view("web.takeaway", compact("idproducto"));
    }
}
