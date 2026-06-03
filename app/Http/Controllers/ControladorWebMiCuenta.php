<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Pedido;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;

class ControladorWebMiCuenta extends Controller
{
    public function index()
    {   
        $id = Session::get('idCliente');
        $cliente = new Cliente();
        $cliente->obtenerPorId($id);
        $pedido = new Pedido();
        $aPedidos = $pedido->obtenerPorCliente($id);
        return view("web.mi-cuenta", compact("aPedidos", "cliente"));
    }

    public function guardar(Request $request)
    {
        $id = Session::get('idCliente');
        $cliente = new Cliente();
        $cliente->cargarDesdeRequest($request);
        $cliente->idcliente = $id;
        $cliente->guardar();
        return redirect('/mi-cuenta');
    }

    public function cerrarSesion()
    {
    }
}
