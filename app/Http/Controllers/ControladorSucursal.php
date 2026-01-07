<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Sucursal;

class ControladorSucursal extends Controller{
    public function nuevo()
    {
        $titulo = "Nueva sucursal";
        return view('sistema.sucursal-nuevo', compact('titulo'));
    }
}
