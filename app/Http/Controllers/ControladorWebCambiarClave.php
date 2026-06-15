<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use Illuminate\Http\Request;
use Session;

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
        $cliente = new Cliente();
        $id = Session::get('idCliente');
        $clave1 = $request->input('txtClave1');
        $clave2 = $request->input('txtClave2');

        if($clave1 != "" && $clave1 == $clave2){
            $cliente->obtenerPorId($id);
            $cliente->clave = password_hash($clave1, PASSWORD_DEFAULT);
            $cliente->guardar();

            $msg['ESTADO'] = "success";
            $msg['MSG'] = "Clave actualizada con exito.";
            return view('web.cambiar-clave', compact('msg'));
        } else {
            $msg['ESTADO'] = "danger";
            $msg['MSG'] = "Las claves no coinciden.";
            return view('web.cambiar-clave', compact('msg'));
        }
    }
}
