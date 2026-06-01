<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sucursal;
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
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();
        $CorreoIngresado = $request->input('txtEmail');
        $claveIngresada = $request->input('txtClave');
        
        $cliente = new Cliente();
        $cliente->obtenerPorCorreo($CorreoIngresado);
        
        if($cliente->correo != ""){
            if(password_verify($claveIngresada, $cliente->clave)){
                return view('web.index', compact('aSucursales'));
            } else {
            $msg["ESTADO"] = "danger";
            $msg["MSG"] = "Credenciales incorrectas";
            return view('web.login', compact('aSucursales', 'msg'));
            }
        }
    }
}
