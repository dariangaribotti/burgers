<?php 

namespace App\Http\Controllers;

use App\Entidades\Cliente; //include_once "app/Entidades/Sistema/Cliente.php";
use Illuminate\Http\Request;

require app_path() . '/start/constants.php'; //La busca desde la raiz del proyecto require app_path(), desde el directorio de App

class ControladorCliente extends Controller {

    public function nuevo(){
      $titulo = "Nuevo cliente";
      return view('sistema.cliente-nuevo', compact('titulo'));
    }

    public function index(){
      $titulo = "Listado de clientes";
      return view('sistema.cliente-listar', compact('titulo'));   
    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Cliente();
        $aClientes = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aClientes) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/cliente/' . $aClientes[$i]->idcliente . '">' . $aClientes[$i]->nombre . '</a>';
            $row[] = $aClientes[$i]->apellido;
            $row[] = $aClientes[$i]->correo;
            $row[] = $aClientes[$i]->dni;
            $row[] = $aClientes[$i]->celular;
            $row[] = $aClientes[$i]->clave;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aClientes), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aClientes), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function guardar(Request $request) { // Prevenimos alguna inyección gracias al Request de Laravel
        try {
            //Define la entidad servicio
            $titulo = "Modificar cliente";
            $entidad = new Cliente();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "" || $entidad->apellido == "" || $entidad->correo == "" || $entidad->dni == "" || $entidad->celular == "" || $entidad->clave == "") {
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
                $_POST["id"] = $entidad->idcliente;
                return view('sistema.cliente-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT; 
        }

        $id = $entidad->idcliente;
        $cliente = new Cliente();
        $cliente->obtenerPorId($id);
        
        return view('sistema.cliente-nuevo', compact('msg', 'cliente', 'titulo')) . '?id=' . $cliente->idcliente;
    }
}
?>