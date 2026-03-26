<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Pedido;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;
use Illuminate\Http\Request;

class ControladorWebMiCuenta extends Controller
{
    public function index()
    {   
        $cliente = new Cliente();
        $pedido = new Pedido();
        $aPedidos = $pedido->obtenerEstado();
        return view("web.mi-cuenta", compact("aPedidos", "cliente"));
    }

    public function guardar(Request $request)
    {
        $cliente = new Cliente();
        $pedido = new Pedido();
        $aPedidos = $pedido->obtenerEstado();
        $cliente->cargarDesdeRequest($request);
        $cliente->guardar();
        
        return view("web.mi-cuenta", compact("cliente"));
    }
}
