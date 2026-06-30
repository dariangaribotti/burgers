<?php

namespace App\Http\Controllers;
use App\Entidades\Pedido;

use Illuminate\Http\Request;

class ControladorWebMercadoPago extends Controller
{
    public function aprobar($idPedido)
    {
      $pedido = new Pedido();
      $pedido->fk_idestado = 5;
      $pedido->obtenerPorId($idPedido);
      $pedido->guardar();
      return redirect("/mi-cuenta");
    }

    public function pendiente($idPedido)
    {
      $pedido = new Pedido();
      $pedido->obtenerPorId($idPedido);
      $pedido->fk_idestado = 2;
      $pedido->guardar();
      return redirect("/mi-cuenta");
    }

    public function error($idPedido)
    {
      $pedido = new Pedido();
      $pedido->obtenerPorId($idPedido);
      $pedido->fk_idestado = 4;
      $pedido->guardar();
      return redirect("/mi-cuenta");
    }
}
