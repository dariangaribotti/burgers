<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use Illuminate\Http\Request;
use Session;

require app_path() . '/start/constants.php';

class ControladorWebCambiarClave extends Controller
{
    public function index()
    {
        $id = Session::get('idCliente');
        if ($id != "") {
            return view("web.cambiar-clave");
        } else {
            return redirect('/login');
        }
        
    }

    public function cambiarClave(Request $request)
    {
        $claveIngresada = $request->input('txtClave');
        $id = Session::get('idCliente');

        if ($id != "") {
            $cliente = new Cliente();
            $cliente->idcliente = $id;
            $cliente->clave = password_hash($claveIngresada, PASSWORD_DEFAULT);
            $cliente->actualizarClave();

            $msg['ESTADO'] = "success";
            $msg['MSG'] = "Clave actualizada con exito";
            return view('web.cambiar-clave', compact('msg'));
        } else {
            $msg['ESTADO'] = "danger";
            $msg['MSG'] = "Error: Sesión no válida.";

            return view('web.cambiar-clave', compact('msg'));
        }
    }
}
