<?php

namespace App\Http\Controllers;

use App\Entidades\Pedido;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;

class ControladorWebMiCuenta extends Controller
{
    public function index()
    { 
            $pedido = new Pedido();
            $aPedidos = $pedido->obtenerEstado();
            return view("web.mi-cuenta", compact("aPedidos"));
    }
}
