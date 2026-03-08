<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;
use Illuminate\Http\Request;

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
    $cliente->clave = $request->input("txtClave");
    $cliente->insertar();
    return redirect("/login");
    /*
    1. metodo registrarse
    2. instanciar la clase cliente
    3. cargar el objeto, recien instanciado con los valores que vienen con el formulario, para eso usar request input
    4. luego llamar al metodo insertar del objeto cliente
    5. listo

    Cuando cargo los datos al formulario del cliente, se guarda ya encriptado cuando se asigna en el objeto
    */
    }
}
