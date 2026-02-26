<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente; //include_once "app/Entidades/Sistema/Cliente.php";
use App\Entidades\Pedido;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php'; //La busca desde la raiz del proyecto require app_path(), desde el directorio de App

class ControladorCliente extends Controller
{

      public function nuevo()
      {

            $titulo = "Nuevo cliente";
            if (Usuario::autenticado() == true) {
                  if (!Patente::autorizarOperacion("CLIENTEALTA")) {
                        $codigo = "CLIENTEALTA";
                        $mensaje = "No tiene permisos para la operación";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  } else {
                        $cliente = new Cliente();
                        return view('sistema.cliente-nuevo', compact('titulo', 'cliente'));
                  }
            } else {
                  return redirect('admin/login');
            }
      }

      public function index()
      {
            $titulo = "Listado de clientes";
            if (Usuario::autenticado() == true) {
                  if (!Patente::autorizarOperacion("CLIENTECONSULTA")) {
                        $codigo = "CLIENTECONSULTA";
                        $mensaje = "No tiene permisos para la operación";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  } else {
                        return view('sistema.cliente-listar', compact('titulo'));
                  }
            } else {
                  return redirect('admin/login');
            }
      }

      public function editar($id)
      {
            $titulo = "Editar";
            $cliente = new Cliente();
            $cliente->obtenerPorId($id);
            if (Usuario::autenticado() == true) {
                  if (!Patente::autorizarOperacion("CLIENTEEDITAR")) {
                        $codigo = "CLIENTEEDITAR";
                        $mensaje = "No tiene permisos para la operación";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  } else {
                        return view('sistema.cliente-nuevo', compact('titulo', 'cliente'));
                  }
            } else {
                  return redirect('admin/login');
            }
      }

      public function eliminar(Request $request)
      {
            if (Usuario::autenticado() == true) {
                  if (!Patente::autorizarOperacion("CLIENTEEDITAR")) {
                        $resultado["err"] = EXIT_FAILURE;
                        $resultado["mensaje"] = "No tiene permisos para la operación.";
                  } else {
                        $id = $request->input("id");
                        $pedido = new Pedido();
                        if ($pedido->existePedidoAsociado($id)) {
                              $resultado["err"] = EXIT_FAILURE;
                              $resultado["mensaje"] = "No se puede eliminar un cliente asociado con un pedido.";
                        } else {
                              $cliente = new Cliente();
                              $cliente->idcliente = $id;
                              $cliente->eliminar();
                              $resultado["err"] = EXIT_SUCCESS;
                              $resultado["mensaje"] = "Registro eliminado exitosamente.";
                        }
                        return json_encode($resultado);
                  }
            } else {
                  $resultado["err"] = EXIT_FAILURE;
                  $resultado["mensaje"] = "Usuario no autenticado.";
            }
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

      public function guardar(Request $request)
      { // Prevenimos alguna inyección gracias al Request de Laravel
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
