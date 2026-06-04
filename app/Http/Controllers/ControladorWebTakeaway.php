<?php

namespace App\Http\Controllers;

use App\Entidades\Producto;
use App\Entidades\Categoria;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
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

    public function insertar(){
        //Guardo los datos que almacene para el carrito
        //Envio los datos al carrito
    }
}
