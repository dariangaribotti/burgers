<?php

namespace App\Http\Controllers;

use App\Entidades\Sucursal;
use App\Entidades\Categoria;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';
class ControladorSucursal extends Controller{
    public function nuevo()
    {
        $titulo = "Nueva sucursal";
        $sucursal = new Sucursal();
        return view('sistema.sucursal-nuevo', compact('titulo', 'sucursal'));
    }

	public function index(){
		$titulo = "Listado de sucursales";
		return view('sistema.sucursal-listar', compact('titulo'));
	}

    public function editar($id){
        $titulo = "Editar";
        $sucursal = new Sucursal();
        $sucursal->obtenerPorId($id);
        $categoria = new Categoria();
        $categoria->obtenerPorId($id);
        return view('sistema.sucursal-nuevo', compact('titulo', 'sucursal', 'categoria'));
    }

    public function guardar(request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar sucursal";
            $entidad = new Sucursal();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "" || $entidad->telefono == "" || $entidad->direccion == "" || $entidad->linkmapa == ""){
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
                $_POST["id"] = $entidad->idsucursal;
                return view('sistema.sucursal-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT; 
        }

        $id = $entidad->idsucursal;
        $sucursal = new Sucursal();
        $sucursal->obtenerPorId($id);
        
        return view('sistema.sucursal-nuevo', compact('msg', 'sucursal', 'titulo')) . '?id=' . $sucursal->idsucursal;
    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $sucursal = new Sucursal();
        $aSucursal = $sucursal->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aSucursal) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/sucursal/' . $aSucursal[$i]->idsucursal . '">' . $aSucursal[$i]->nombre . '</a>';
            $row[] = $aSucursal[$i]->telefono;
            $row[] = $aSucursal[$i]->direccion;
            $row[] = $aSucursal[$i]->linkmapa;
            $cont++;
            $data[] = $row;
        }
        
        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aSucursal), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aSucursal), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
}
