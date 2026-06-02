<?php

namespace App\Http\Controllers;

use App\Entidades\Producto;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;

class ControladorWebTakeaway extends Controller
{
    public function index()
    {   
        $pg = "takeaway";
        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();
        $aCategorias = $producto->obtenerPorCategoria();
        return view("web.takeaway", compact('pg', 'aProductos', 'aCategorias'));
    }
}
