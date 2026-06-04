<?php

namespace App\Http\Controllers;

use App\Entidades\Carrito;
use App\Entidades\Producto;
use App\Entidades\Categoria;
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
        $producto = new Producto();
        $categoria = new Categoria();

        $aProductos = $producto->obtenerPorCategoria();
        $aCategorias = $categoria->obtenerTodos();

        $id = Session::get("idCliente");
        $idProducto = $Request->input("txtProducto");
        $cantidad = $Request->input("txtCantidad");
        
        if((isset($id) && $id != "")){
            $carrito = new Carrito();
            $carrito->fk_idcliente = $id;
            $carrito->fk_idproducto = $idProducto;
            $carrito->cantidad = $cantidad;
            $carrito->insertar();   

            $msg["ESTADO"] = "success";
            $msg["MSG"] = "El producto se ha agregado al carrito";
            return view("web.takeaway", compact("msg", "aProductos", "aCategorias"));
        } else {
            $msg["ESTADO"] = "danger";
            $msg["MSG"] = "No agregó ningún producto al carrito";
            return view("web.takeaway", compact("msg", "aProductos", "aCategorias"));
        }
    }
}
