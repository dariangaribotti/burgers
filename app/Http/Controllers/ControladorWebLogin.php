<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;
use Illuminate\Http\Request;

class ControladorWebLogin extends Controller
{
    public function index()
    {
        return view("web.login");
    }

    public function ingresar(Request $request)
    {
        $CorreoIngresado = fescape_string($request->input('txtEmail'));
        $claveIngresada = fescape_string($request->input('txtClave'));

        $cliente = new Cliente();
        
        $cliente->obtenerPorCliente();
      
        /*
        1. __Capturar los datos del formulario: Obtener el correo y la clave ingresados usando $request->input(...).
        
        2. __Instanciar la clase Cliente: Crear un nuevo objeto Cliente ($cliente = new Cliente();).
        
        3. Buscar al cliente en la base de datos: Vas a necesitar tener o crear un método en la entidad Cliente (ej: obtenerPorCorreo($correo)) que busque si ese mail existe y te devuelva un array con los datos ($lstCliente).
        
        4. Validar si el cliente existe: Hacer un if (count($lstCliente) > 0). 
           - Si NO existe, armar el array $msg con estado "danger" y texto "Correo incorrecto", y retornar la vista web.login.
           
        5. Validar la clave: Si el cliente existe, hacer otro if adentro comparando la clave ingresada con la clave encriptada de la base de datos (usando un método como validarClave() igual que hace el Usuario).
           - Si la clave está MAL, armar el array $msg con "Contraseña incorrecta" y retornar la vista.
           
        6. Iniciar Sesión (¡El paso más importante!): Si la clave está BIEN, guardar en la Session los datos. 
           ¡OJO! Usá nombres distintos al admin. 
           Ejemplo: Session::put('cliente_id', $lstCliente[0]->idcliente);
           
        7. Redirigir: Usar return redirect('/mi-cuenta'); para mandarlo a su panel si todo salió perfecto.
        */
    }
}
