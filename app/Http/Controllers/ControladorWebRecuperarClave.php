<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

require app_path() . '/start/constants.php';

class ControladorWebRecuperarClave extends Controller
{
    public function index()
    {
        return view("web.recuperar-clave");
    }

    public function recuperarClave(Request $request)
    {  
      $correoIngresado = $request->input('txtEmail');
      $claveIngresada = $request->input('txtClave');

      $cliente = new Cliente();
      $lstcliente = $cliente->obtenerPorCorreo($correoIngresado);
      

      if($lstcliente != null){
        $cliente->idcliente = $lstcliente->idcliente;
        $cliente->clave = password_hash($claveIngresada, PASSWORD_DEFAULT);
        $cliente->actualizarClave();

        $msg['ESTADO'] = "success";
        $msg['MSG'] = "Clave actualizada cone exito"; 
        return view('web.recuperar-clave', compact('msg'));   
      } else {
        $msg['ESTADO'] = "danger";
        $msg['MSG'] = "No se ha registrado aun"; 

        return view('web.recuperar-clave', compact('msg'));       
      }
    }

      // 1. Capturar los datos del formulario (correo y la nueva clave).

      // 2. Instanciar la clase Cliente.

      // 3. Buscar al cliente en la base de datos por su correo (usar obtenerPorCorreo).

      // 4. Validar si el cliente existe:
      
      //    4.1. Si existe:
      //         - Cargar el objeto con los datos obtenidos (¡No olvidar el idcliente!).
      //         - Encriptar la nueva clave y asignarla al objeto.
      //         - Llamar al método guardar() para ejecutar el UPDATE.
      //         - Preparar mensaje de éxito.

      //    4.2. Si NO existe:
      //         - Preparar mensaje de error (correo no encontrado).

      // 5. Retornar la vista de recuperar-clave pasando el mensaje ($msg).
      
}
