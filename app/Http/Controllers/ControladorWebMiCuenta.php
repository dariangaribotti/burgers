<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Pedido;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;

class ControladorWebMiCuenta extends Controller
{
    public function index()
    {   
        dd("Llegué a Mi Cuenta. El contenido de la sesión es: ", session()->all());
        // 1. Si NO hay sesión iniciada, lo redirigimos a la pantalla de Login.
        if(!Session::has('usuario_id')){
            return redirect('/login');
        }
        // 2. Obtenemos el ID del usuario desde la sesión y lo guardamos en una variable.
        $id = Session::get('usuario_id');
        // 3. Instanciamos un Cliente y buscamos sus datos en la BD usando ese ID que recién obtuvimos.
        $cliente = new Cliente();
        $cliente->obtenerPorId($id);
        // 4. Instanciamos un Pedido y buscamos la lista de pedidos que le pertenecen a este ID.
        $pedido = new Pedido();
        $aPedidos = $pedido->obtenerPorCliente($id);
        // 5. Retornamos la vista "web.mi-cuenta" pasándole las variables del cliente y de los pedidos.
        return view("web.mi-cuenta", compact("aPedidos", "cliente"));
    }

    public function guardar(Request $request)
    {
        // 1. Por seguridad, si NO hay sesión iniciada, lo redirigimos al Login.
        if(!Session::has('usuario_id')){
            return redirect('/login');
        }
        // 2. Obtenemos el ID del usuario desde la sesión.
        $id = Session::get('usuario_id');
        // 3. Instanciamos un Cliente y le cargamos los datos que vienen escritos en el formulario ($request).
        $cliente = new Cliente();
        $cliente->cargarDesdeRequest($request);
        // 4. Le asignamos a la fuerza el ID de la sesión a ese cliente (para garantizar que actualizamos su usuario y no otro).
        $cliente->idcliente = $id;
        // 5. Ejecutamos la función para guardar los cambios en la base de datos.
        $cliente->guardar();
        // 6. Redirigimos nuevamente a la ruta de "Mi Cuenta" para recargar la página y que el usuario vea sus datos nuevos.
        return redirect('/mi-cuenta');
    }

    public function cerrarSesion()
    {
        // 1. Eliminamos/olvidamos la variable de sesión que identifica al usuario.
        Session::forget('usuario_id');
        // 2. Lo redirigimos a la pantalla de Login (o al inicio de la web).
        return redirect('/login');
    }
}
