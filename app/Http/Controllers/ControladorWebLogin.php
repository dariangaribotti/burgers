<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;
use Illuminate\Http\Request;

class ControladorWebLogin extends Controller
{
    public function index()
    {
        return view("web.login");
    }

    public function ingresar(Request $request)
    {
        $CorreoIngresado = $request->input('txtEmail');
        $claveIngresada = $request->input('txtClave');

        $cliente = new Cliente();
        
        $lstCliente = $cliente->obtenerPorCorreo($CorreoIngresado);

        if($lstCliente == null){
            $msg['ESTADO'] = "danger";
            $msg['MSG'] = "Correo o contraseña incorrectos"; 
            return view('web.login', compact('msg'));
        }

        $clienteEncontrado = $lstCliente;

        if (password_verify($claveIngresada, $clienteEncontrado->clave)) {

            Session::put('usuario_id', $clienteEncontrado->idcliente);
            return redirect()->route('mi.cuenta');
            
        } else {
            $msg['ESTADO'] = "danger";
            $msg['MSG'] = "Correo o contraseña incorrectos";
            return view('web.login', compact('msg'));
        }
    }
}
