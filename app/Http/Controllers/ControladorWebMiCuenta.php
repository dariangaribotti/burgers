<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Pedido;
use Illuminate\Http\Request;

use Session;

class ControladorWebMiCuenta extends Controller
{
    public function index()
    {   
        $id = Session::get("idCliente");
        
        if($id != ""){
            //Si tiene la sesion iniciada, le muestra sus datos
            $cliente = new Cliente();
            $pedido = new Pedido();

            $cliente->obtenerPorId($id);
            $aPedidos = $pedido->obtenerPorCliente($id);

            return view("web.mi-cuenta", compact("cliente", "aPedidos"));
        } else {
            //Si no tiene la sesion iniciada, lo devuelve al login
            return redirect("/login");
        }
    }

    public function guardar(Request $request)
    {   
        $id = Session::get("idCliente");
        
        $cliente = new Cliente();

        $cliente->obtenerPorId($id);

        $cliente->nombre = $request->input("txtNombre");
        $cliente->apellido = $request->input("txtApellido");
        $cliente->celular = $request->input("txtCelular");
        $cliente->correo = $request->input("txtEmail");
        $cliente->dni = $request->input("txtDocumento");

        $pedido = new Pedido();
        $aPedidos = $pedido->obtenerPorCliente("idCliente");

        if($request->filled(["txtNombre", "txtApellido", "txtCelular", "txtEmail", "txtDocumento"])){
            $cliente->guardar();
            $msg["ESTADO"] = "success";
            $msg["MSG"] = "Datos actualizados!";
            return view("web.mi-cuenta", compact("cliente", "aPedidos", "msg"));
        } else {
            $msg["ESTADO"] = "danger";
            $msg["MSG"] = "Complete todos los datos";
            return view("web.mi-cuenta", compact("cliente", "aPedidos", "msg"));
        }
    }
}
