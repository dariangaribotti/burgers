<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorWebRecuperarClave extends Controller
{
    public function index()
    {
        return view("web.recuperar-clave");
    }

    public function recuperarClave(Request $request)
    {  
      $correoIngresado = $request->input('txtEmail');
      $claveIngresada = $request->input('txtClave');

      $cliente = new Cliente();
      $lstcliente = $cliente->obtenerPorCorreo($correoIngresado);
      

      if($lstcliente != null){
        $cliente->idcliente = $lstcliente->idcliente;
        $cliente->clave = password_hash($claveIngresada, PASSWORD_DEFAULT);
        $cliente->actualizarClave();

        $msg['ESTADO'] = "success";
        $msg['MSG'] = "Clave actualizada con exito"; 
        return view('web.recuperar-clave', compact('msg'));   
      } else {
        $msg['ESTADO'] = "danger";
        $msg['MSG'] = "No se ha registrado aun"; 

        return view('web.recuperar-clave', compact('msg'));       
      }
    }
      
}
