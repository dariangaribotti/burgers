<?php 

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido_producto extends Model {

      protected $table = 'pedidos_productos';
      public $timestamps = false;

      protected $fillable = [ //Protege la base datos de cualquier inyección.
    'idpedido_producto', 'fk_idpedido', 'fk_idproducto', 'cantidad', 'preciounitario', 'total'
    ];

    public function cargarDesdeRequest($request) {
        $this->idpedido_producto = $request->input('id') != "0" ? $request->input('id') : $this->idpedido_producto;
        $this->fk_idpedido = $request->input('txtPedido');
        $this->fk_idproducto = $request->input('txtProducto');
        $this->cantidad = $request->input('txtCantidad') != "" ? $request->input('txtCantidad') : 0;
        $this->preciounitario = $request->input('txtPrecioUnitario');
        $this->total = $request->input('txtTotal');
    }

    public function insertar()
    {
        $sql = "INSERT INTO pedidos_productos (
                fk_idpedido,
                fk_idproducto,
                cantidad,
                preciounitario,
                total,
            ) VALUES (?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->fk_idpedido,
            $this->fk_idproducto,
            $this->cantidad,
            $this->preciounitario,
            $this->total,
        ]);
        return $this->idpedido_producto = DB::getPdo()->lastInsertId();
    }

	public function guardar()
    {
        $sql = "UPDATE pedidos_productos SET
            fk_idpedido=$this->fk_idpedido,
            fk_idproducto=$this->fk_idproducto,
            cantidad=$this->cantidad,
            preciounitario=$this->preciounitario,
            total=$this->total
            WHERE idpedido_producto=?";
        $affected = DB::update($sql, [$this->idpedido_producto]);
    }

	public function eliminar()
    {
        $sql = "DELETE FROM pedidos_productos WHERE
            idpedido_producto=?";
        $affected = DB::delete($sql, [$this->idpedido_producto]);
    }

	public function obtenerTodos()
    {
        $sql = "SELECT
                idpedido_producto,
                fk_idpedido,
                fk_idproducto,
                cantidad,
                preciounitario,
                total
            FROM pedidos_productos";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

	public function obtenerPorId($idPedidoProducto)
    {
        $sql = "SELECT
                idpedido_producto,
                fk_idpedido,
                fk_idproducto,
                cantidad,
                preciounitario,
                total
            FROM pedidos_productos WHERE idpedido_producto = $idPedidoProducto";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idpedido_producto = $lstRetorno[0]->idpedido_producto;
            $this->fk_idpedido = $lstRetorno[0]->fk_idpedido;
            $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
            $this->cantidad = $lstRetorno[0]->cantidad;
            $this->preciounitario = $lstRetorno[0]->preciounitario;
            $this->total = $lstRetorno[0]->total;
            return $this;
        }
        return null;
    }
}

?>