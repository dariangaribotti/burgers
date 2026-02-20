<?php 

namespace App\Http\Controllers;

use App\Entidades\Pedido;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\Estado;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorPedido extends Controller {
      
      public function nuevo(){
            $titulo = "Nuevo pedido";

            $pedido = new Pedido();

            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            $cliente = new Cliente();
            $aClientes = $cliente->obtenerTodos();

            $estado = new Estado();
            $aEstados = $estado->obtenerTodos();
            return view("sistema.pedido-nuevo", compact('titulo', 'pedido', 'aSucursales', 'aClientes', 'aEstados'));
      }

      public function index(){
            $titulo = "Listado de pedidos";
            return view('sistema.pedido-listar', compact('titulo'));
      }

      public function editar($id){
        $titulo = "Editar";

        $pedido = new Pedido();
        $pedido->obtenerPorId($id);

        $sucursal = new Sucursal();
        $sucursal->obtenerPorId($id);

        $cliente = new Cliente();
        $cliente->obtenerPorId($id);

        $estado = new Estado();
        $estado->obtenerPorId($id);

        $aSucursales = $sucursal->obtenerTodos();
        $aClientes = $cliente->obtenerTodos();
        $aEstados = $estado->obtenerTodos();
        return view('sistema.pedido-nuevo', compact('titulo', 'pedido', 'sucursal', 'cliente', 'estado', 'aSucursales', 'aClientes', 'aEstados'));
    }

      public function guardar(request $request){ 
             try {
            //Define la entidad servicio
            $titulo = "Modificar cliente";
            $entidad = new Pedido();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->descripcion == ""){
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
                $_POST["id"] = $entidad->idpedido;
                return view('sistema.pedido-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT; 
        }

        $id = $entidad->idpedido;
        $pedido = new Pedido();
        $pedido->obtenerPorId($id);
        
        return view('sistema.pedido-nuevo', compact('msg', 'pedido', 'titulo')) . '?id=' . $pedido->idpedido;
    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $pedido = new Pedido();
        $aPedidos = $pedido->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aPedidos) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/pedido/' . $aPedidos[$i]->idpedido . '">' . $aPedidos[$i]->fk_idcliente . '</a>';
            $row[] = $aPedidos[$i]->descripcion;
            $row[] = $aPedidos[$i]->total;
            $row[] = $aPedidos[$i]->fecha;
            $row[] = $aPedidos[$i]->fk_idsucursal;
            $row[] = $aPedidos[$i]->fk_idestado;
            $cont++;
            $data[] = $row;
        }
        
        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aPedidos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aPedidos), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
}

?>