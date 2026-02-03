<?php 

namespace App\Http\Controllers;

use App\Entidades\Producto; //include_once "app/Entidades/Sistema/Menu.php";
use App\Entidades\Categoria;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorProducto extends Controller {
      
    public function nuevo(){
        $titulo = "Nuevo producto";
        $categoria = new Categoria();
        $aCategorias = $categoria->obtenerTodos();
        return view('sistema.producto-nuevo', compact('titulo', 'aCategorias'));
    }

    public function index(){
      $titulo = "Listado de Productos";
      return view('sistema.producto-listar', compact('titulo'));
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidad = new Producto();
        $aProducto = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aProducto) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/producto/' . $aProducto[$i]->idproducto . '">' . $aProducto[$i]->nombre . '</a>';
            $row[] = $aProducto[$i]->cantidad;
            $row[] = $aProducto[$i]->precio;
            $row[] = $aProducto[$i]->imagen;
            $row[] = $aProducto[$i]->fk_idcategoria;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aProducto), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aProducto), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function guardar(request $request){
         try {
            //Define la entidad servicio
            $titulo = "Modificar producto";
            $entidad = new Producto();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "" || $entidad->cantidad == "" || $entidad->precio == ""){
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
                $_POST["id"] = $entidad->idproducto;
                return view('sistema.producto-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT; 
        }

        $id = $entidad->idproducto;
        $producto = new Producto();
        $producto->obtenerPorId($id);
        
        return view('sistema.producto-nuevo', compact('msg', 'producto', 'titulo')) . '?id=' . $producto->idproducto;
    }
}
?>