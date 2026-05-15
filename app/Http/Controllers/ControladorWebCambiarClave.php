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
        if (!Session::get('usuario_id')){
            return redirect('/login');
        }
        return view("web.cambiar-clave");
    }

    public function cambiarClave(Request $request){
      $claveIngresada = $request->input('txtClave');
      $idCliente = Session::get('usuario_id');
      
      if($idCliente > 0){
        $cliente = new Cliente();
        $cliente->idcliente = $idCliente;
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
