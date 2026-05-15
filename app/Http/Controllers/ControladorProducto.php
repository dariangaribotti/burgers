<?php

namespace App\Http\Controllers;

use App\Entidades\Producto; //include_once "app/Entidades/Sistema/Menu.php";
use App\Entidades\Pedido;
use App\Entidades\Categoria;
use App\Entidades\Cliente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorProducto extends Controller
{

    public function nuevo()
    {
        $titulo = "Nuevo producto";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PRODUCTOCONSULTA")) {
                $codigo = "PRODUCTOCONSULTA";
                $mensaje = "No tiene permisos para la operación";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $categoria = new Categoria();
                $aCategorias = $categoria->obtenerTodos();
                $producto = new Producto();
                return view('sistema.producto-nuevo', compact('titulo', 'aCategorias', 'producto'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function index()
    {
        $titulo = "Listado de Productos";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PRODUCTOCONSULTA")) {
                $codigo = "PRODUCTOCONSULTA";
                $mensaje = "No tiene permisos para la operación";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('sistema.producto-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function editar($id)
    {
        $titulo = "Editar";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PRODUCTOEDITAR")) {
                $codigo = "PRODUCTOEDITAR";
                $mensaje = "No tiene permisos para la operación";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $producto = new Producto();
                $producto->obtenerPorId($id);

                $categoria = new Categoria();
                $aCategorias = $categoria->obtenerTodos();

                return view('sistema.producto-nuevo', compact('titulo', 'producto', 'aCategorias'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function eliminar(Request $request)
    {
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PRODUCTOELIMINAR")) {
                $resultado["err"] = EXIT_FAILURE;
                $resultado["mensaje"] = "No tiene permisos para la operación.";
            } else {
                $idProducto = $request->input("id");

                $producto = new Producto();
                $producto->idproducto = $idProducto;
                $producto->eliminar();

                $resultado["err"] = EXIT_SUCCESS;
                $resultado["mensaje"] = "Registro eliminado exitosamente";
            }
        } else {
            $resultado["err"] = EXIT_FAILURE;
            $resultado["mensaje"] = "Usuario no autenticado.";
        }
        return json_encode($resultado);
    }

    public function cargarGrilla()
    {
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
            $row[] = number_format($aProducto[$i]->precio, 2, '.', ',');
            // Verificamos que el producto realmente tenga una imagen guardada
            if ($aProducto[$i]->imagen != "") {
                // Usamos asset() para generar la ruta web hacia public/files/
                $rutaImagen = asset('files/' . $aProducto[$i]->imagen);
                // Armamos la etiqueta HTML de la imagen (le puse 50px para que no rompa la tabla)
                $row[] = '<img src="' . $rutaImagen . '" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">';
            } else {
                // Si no tiene imagen, mostramos un texto alternativo
                $row[] = '<span class="badge badge-secondary">Sin imagen</span>';
            }
            $row[] = $aProducto[$i]->categoria;
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

    public function guardar(Request $request)
    {
        try {
            //Define la entidad servicio
            $titulo = "Guardar producto";
            $entidad = new Producto();
            $entidad->cargarDesdeRequest($request);

            if (isset($_FILES["fileImagen"]) && $_FILES["fileImagen"]["error"] === UPLOAD_ERR_OK) { //Se adjunta imagen
                $extension = pathinfo($_FILES["fileImagen"]["name"], PATHINFO_EXTENSION);
                $nombre = date("Ymdhmsi") . ".$extension";
                $archivo = $_FILES["fileImagen"]["tmp_name"];
                move_uploaded_file($archivo, public_path("files/" . $nombre)); //guarda el archivo
                $entidad->imagen = $nombre;
            }

            //validaciones
            if ($entidad->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST["id"] > 0) {
                    $productAnt = new Producto();
                    $productAnt->obtenerPorId($entidad->idproducto);

                    if (isset($_FILES["fileImagen"]) && $_FILES["fileImagen"]["error"] === UPLOAD_ERR_OK) {
                        //Eliminar imagen anterior
                        @unlink(public_path("files/" . $productAnt->imagen));
                    } else {
                        $entidad->imagen = $productAnt->imagen;
                    }

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
