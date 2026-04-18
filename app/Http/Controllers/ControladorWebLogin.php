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
        // 1. Capturar los datos del formulario
        $CorreoIngresado = $request->input('txtEmail');
        $claveIngresada = $request->input('txtClave');

        // 2. Instanciar la clase Cliente
        $cliente = new Cliente();
        
        // 3. Buscar al cliente en la base de datos 
        // (Asegurate de crear este método en tu entidad Cliente si no existe)
        $lstCliente = $cliente->obtenerPorCorreo($CorreoIngresado);

        // 4. Validar si el cliente existe (Si el conteo es 0, NO existe)
        if($lstCliente == null){
            $msg['ESTADO'] = "danger";
            $msg['MSG'] = "Correo o contraseña incorrectos"; 
            return view('web.login', compact('msg'));
        }

        // Si llegamos hasta acá, el correo existe. Guardamos los datos del cliente.
        $clienteEncontrado = $lstCliente;

        // 5. Validar la clave
        // Usamos password_verify asumiendo que la guardaste con password_hash()
        // Si no usás encriptación (no recomendado), cambiar a: if($claveIngresada == $clienteEncontrado->clave)
        if (password_verify($claveIngresada, $clienteEncontrado->clave)) {
            
            // 6. Iniciar Sesión
            Session::put('cliente_id', $clienteEncontrado->idcliente);
            
            // 7. Redirigir
            return redirect()->route('mi.cuenta');
            
        } else {
            // Si la clave está MAL
            $msg['ESTADO'] = "danger";
            $msg['MSG'] = "Correo o contraseña incorrectos";
            return view('web.login', compact('msg'));
        }
    }
}
