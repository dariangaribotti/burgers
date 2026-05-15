<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;

class ControladorWebContacto extends Controller
{
    public function index()
    {   
        $pg = "contacto";
        return view("web.contacto", compact('pg'));
    }
}
