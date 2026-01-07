<?php 

namespace App\Http\Controllers;

use App\Entidades\Sistema\Cliente; //include_once "app/Entidades/Sistema/Menu.php";

class ControladorCliente extends Controller 
{
    public function nuevo(){
      $titulo = "Nuevo cliente";
      return view('sistema.cliente-nuevo', compact('titulo'));
    }
}
?>