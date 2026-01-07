<?php 

namespace App\Http\Controllers;

use App\Entidades\Sistema\Categoria; //include_once "app/Entidades/Sistema/Menu.php";

class ControladorCategoria extends Controller {
      
    public function nuevo(){
        $titulo = "Nueva categoria";

        return view('sistema.categoria-nuevo', compact('titulo'));
    }
}
?>