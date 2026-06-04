<?php 
namespace App\Entidades; //Evitamos choques de nombre, el namespace los diferencia.

use DB; //Importa la fachada de base de datos
use Illuminate\Database\Eloquent\Model; //Son atajos para no escribir el código completo.
use Illuminate\Support\Facades\DB as FacadesDB;

class Carrito extends Model {

    protected $table = 'carritos';
    public $timestamps = false;

    protected $fillable = [ //Protege la base datos de cualquier inyección.
    'idcarrito', 'fk_idcliente', 'cantidad'
    ];

    public function cargarDesdeRequest($request) {
        $this->idcarrito = $request->input('id') != "0" ? $request->input('id') : $this->idcarrito;
        $this->fk_idcliente = $request->input('txtCliente');
        $this->fk_idproducto = $request->input('txtProducto');
        $this->cantidad = $request->input('txtCantidad');
    }

    public function insertar()
    {
        $sql = "INSERT INTO carritos (
                fk_idcliente,
                fk_idproducto,
                cantidad
            ) VALUES (?, ?, ?);";
        $result = DB::insert($sql, [
            $this->fk_idcliente,
            $this->fk_idproducto,
            $this->cantidad
        ]);
        return $this->idcarrito = DB::getPdo()->lastInsertId();
    }
    
    public function guardar()
    {
        $sql = "UPDATE carritos SET
                fk_idcliente = ?,
                fk_idproducto = ?,
                cantidad = ?
                WHERE idcarrito = ?";
        $affected = DB::update($sql, [
            $this->fk_idcliente,
            $this->fk_idproducto,
            $this->cantidad,
            $this->idcarrito
        ]);
        return $affected;
    }

    public function eliminar()
    {
        $sql = "DELETE FROM carritos WHERE
            idcarrito=?";
        $affected = DB::delete($sql, [$this->idcarrito]);
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                idcarrito,
                fk_idcliente,
                fk_idproducto,
                cantidad
            FROM carritos ORDER BY fk_idcliente ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idCarrito)
    {
        $sql = "SELECT
                idcarrito,
                fk_idcliente,
                fk_idproducto,
                cantidad
            FROM carritos WHERE idcarrito = $idCarrito";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcarrito = $lstRetorno[0]->idcarrito;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            $this->cantidad = $lstRetorno[0]->cantidad;
            return $this;
        }
        return null;
    }

    public function obtenerPorCliente($idCliente){
        $sql = "SELECT 
                    B.imagen, 
                    B.nombre,
                    B.precio
                FROM productos B
                INNER JOIN carritos A ON B.idproducto = A.fk_idproducto
                WHERE A.fk_idcliente = $idCliente";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
}
?>