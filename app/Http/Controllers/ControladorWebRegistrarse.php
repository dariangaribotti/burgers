<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorWebRegistrarse extends Controller
{
    public function index()
    {
        return view("web.registrarse");
    }

    public function registrarse(Request $request)
    {  
    $cliente = new Cliente();
    $cliente->nombre = $request->input("txtNombre");
    $cliente->apellido = $request->input("txtApellido");
    $cliente->correo = $request->input("txtEmail");
    $cliente->dni = $request->input("txtDocumento");
    $cliente->celular = $request->input("txtTelefono");
    $cliente->clave = password_hash($request->input("txtClave"), PASSWORD_DEFAULT);

    if($request->filled(["txtNombre", "txtApellido", "txtEmail", "txtDocumento", "txtTelefono", "txtClave"])){
        $cliente->insertar();
        return redirect("/login");
    } else {
        $msg["MSG"] = "Complete todos los datos.";
        $msg["ESTADO"] = "danger";
        return view("web.registrarse", compact('msg'));
    }
    
    }
}
