<?php 

namespace App\Http\Controllers;

use App\Entidades\Postulacion;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorPostulacion extends Controller{
      public function nuevo(){
            $titulo = "Nueva postulación";
            $postulacion = new Postulacion();
            return view('sistema.postulacion-nuevo', compact('titulo' , 'postulacion'));
      }

      public function index(){
            $titulo = "Listado de Postulaciones";
            return view('sistema.postulacion-listar', compact('titulo'));
      }

      public function editar($id){
        $titulo = "Editar";
        $postulacion = new Postulacion();
        $postulacion->obtenerPorId($id);
        return view('sistema.postulacion-nuevo', compact('titulo', 'postulacion'));
    }

      public function guardar(request $request){
		try {
            //Define la entidad servicio
            $titulo = "Modificar postulacion";
            $entidad = new Postulacion();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "" || $entidad->apellido == "" || $entidad->celular == "" || $entidad->correo == "" || $entidad->curriculum == ""){
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidad->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                    $entidad->insertar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                $_POST["id"] = $entidad->idpostulacion;
                return view('sistema.postulacion-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT; 
        }

        $id = $entidad->idpostulacion;
        $postulacion = new Postulacion();
        $postulacion->obtenerPorId($id);
        
        return view('sistema.postulacion-nuevo', compact('msg', 'postulacion', 'titulo')) . '?id=' . $postulacion->idpostulacion;
    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $postulacion = new Postulacion();
        $aPostulacion = $postulacion->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aPostulacion) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/postulacion/' . $aPostulacion[$i]->idpostulacion . '">' . $aPostulacion[$i]->nombre . '</a>';
            $row[] = $aPostulacion[$i]->apellido;
            $row[] = $aPostulacion[$i]->celular;
            $row[] = $aPostulacion[$i]->correo;
            $row[] = '<a href="/admin/postulacion/' . $aPostulacion[$i]->curriculum . '">Descargar</a>';
            $cont++;
            $data[] = $row;
        }
        
        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aPostulacion), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aPostulacion), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
}

?>