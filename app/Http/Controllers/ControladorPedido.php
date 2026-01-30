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
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            $cliente = new Cliente();
            $aClientes = $cliente->obtenerTodos();

            $estado = new Estado();
            $aEstados = $estado->obtenerTodos();
            return view("sistema.pedido-nuevo", compact('titulo', 'aSucursales', 'aClientes', 'aEstados'));
      }

      public function index(){
            $titulo = "Listado de pedidos";
            return view('sistema.pedido-listar', compact('titulo'));
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
}

?>