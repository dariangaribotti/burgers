<?php 

namespace App\Http\Controllers;

use App\Entidades\Sistema\Postulacion;

class ControladorPostulacion extends Controller{
      public function nuevo(){
            $titulo = "Nueva postulación";
            return view('sistema.postulacion-nuevo', compact('titulo'));
      }
}

?>