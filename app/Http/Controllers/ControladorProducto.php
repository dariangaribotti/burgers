<?php 

namespace App\Http\Controllers;

use App\Entidades\Sistema\Producto; //include_once "app/Entidades/Sistema/Menu.php";

class ControladorProducto extends Controller {
      
    public function nuevo(){
        $titulo = "Nuevo producto";

        return view('sistema.producto-nuevo', compact('titulo'));
    }
}
?>