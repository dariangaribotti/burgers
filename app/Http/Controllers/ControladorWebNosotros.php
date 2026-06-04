<?php
namespace App\Http\Controllers;

use App\Entidades\Postulacion;
use Illuminate\Http\Request;

class ControladorWebNosotros extends Controller
{
    public function index()
    {   
        $pg = "nosotros";
        return view("web.nosotros", compact('pg'));
    }

    public function ingresarPostulacion(Request $request){
        $postulacion = new Postulacion();
        $postulacion->nombre = $request->input("txtNombre");
        $postulacion->apellido = $request->input("txtApellido");
        $postulacion->celular = $request->input("txtCelular");
        $postulacion->correo = $request->input("txtCorreo");
        $postulacion->curriculum = $request->input("fileCurriculum");

        if($request->filled(["txtNombre", "txtApellido", "txtCelular", "txtCorreo"])){
            $postulacion->insertar();
            return redirect("/postulacion-gracias");
        } else {
            $msg["MSG"] = "Complete todos los datos.";
            $msg["ESTADO"] = "danger";
            return view("web.nosotros", compact("msg"));
        }
    }
}
