<?php

namespace App\Http\Controllers;

use App\Entidades\Postulacion;
use Illuminate\Http\Request;

class ControladorWebNosotros extends Controller
{
    public function index()
    {
        return view("web.nosotros");
    }

    public function ingresarPostulacion(Request $request)
    {
        $postulacion = new Postulacion();
        $postulacion->nombre = $request->input("txtNombre");
        $postulacion->apellido = $request->input("txtApellido");
        $postulacion->celular = $request->input("txtCelular");
        $postulacion->correo = $request->input("txtCorreo");
        $postulacion->curriculum = $request->input("archivo");

        if ($request->filled(["txtNombre", "txtApellido", "txtCelular", "txtCorreo"])) {
            if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) { //Se adjunta imagen
                $extension = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);
                $nombre = date("Ymdhmsi") . ".$extension";
                $archivo = $_FILES["archivo"]["tmp_name"];
                if ($extension == "doc" || $extension == "docx" || $extension == "pdf") {
                    // env('APP_PATH') traía "E:\..." y rompía Docker. public_path() calcula la ruta correcta automáticamente.
                    move_uploaded_file($archivo, public_path("/files/$nombre"));
                } else {
                    return "";
                }
                $postulacion->curriculum = $nombre;
            }
            $postulacion->insertar();
            return redirect("/postulacion-gracias");
        } else {
            $msg["MSG"] = "Complete todos los datos.";
            $msg["ESTADO"] = "danger";
            return view("web.nosotros", compact("msg"));
        }
    }
}
