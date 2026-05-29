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
    $cliente->correo = $request->input("txtEmail");
    $cliente->clave = password_hash($request->input("txtClave"), PASSWORD_DEFAULT);

    if(filled($cliente->correo) && filled($cliente->clave)){
        $cliente->registrarse();
        $msg["MSG"] = "Se ha registrado correctamente.";
        $msg["ESTADO"] = "success";
    } else {
        $msg["MSG"] = "Complete todos los datos.";
        $msg["ESTADO"] = "danger";
    }
    return view("web.registrarse", compact('msg'));
    /*
    1. metodo registrarse
    2. instanciar la clase cliente
    3. cargar el objeto, recien instanciado con los valores que vienen con el formulario, para eso usar request input
    4. luego llamar al metodo insertar del obj  eto cliente
    5. listo

    Cuando cargo los datos al formulario del cliente, se guarda ya encriptado cuando se asigna en el objeto
    */
    }
}
