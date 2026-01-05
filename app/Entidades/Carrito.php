<?php 

namespace App\Entidades\Sistema; //Evitamos choques de nombre, el namespace los diferencia.

use DB; //Importa la fachada de base de datos
use Illuminate\Database\Eloquent\Model; //Son atajos para no escribir el código completo.

class Carrito extends Model {

    protected $table = 'carritos';
    public $timestamps = false;

    protected $fillable = [ //Protege la base datos de cualquier inyección.
    'idcarrito', 'fk_idcliente'
    ];

    public function cargarDesdeRequest($request) {
        $this->idcarrito = $request->input('id') != "0" ? $request->input('id') : $this->idcarrito;
        $this->fk_idcliente = $request->input('txtCliente');
    }

    public function insertar()
    {
        $sql = "INSERT INTO carritos (
                fk_idcliente
            ) VALUES (?);";
        $result = DB::insert($sql, [
            $this->fk_idcliente
        ]);
        return $this->idcarrito = DB::getPdo()->lastInsertId();
    }
    
    public function guardar()
    {
        $sql = "UPDATE carritos SET
            fk_idcliente=$this->fk_idcliente
            WHERE idcarrito=?";
        $affected = DB::update($sql, [$this->idcarrito]);
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
                fk_idcliente
            FROM carritos ORDER BY fk_idcliente ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idCarrito)
    {
        $sql = "SELECT
                idcarrito,
                fk_idcliente
            FROM carritos WHERE idcarrito = $idCarrito";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcarrito = $lstRetorno[0]->idcarrito;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            return $this;
        }
        return null;
    }

}

?>