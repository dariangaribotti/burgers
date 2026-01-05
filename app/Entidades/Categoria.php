<?php 

namespace App\Entidades\Sistema; //Evitamos choques de nombre, el namespace los diferencia.

use DB; //Importa la fachada de base de datos
use Illuminate\Database\Eloquent\Model; //Son atajos para no escribir el código completo.

class Categoria extends Model {

    protected $table = 'categorias';
    public $timestamps = false;

    protected $fillable = [ //Protege la base datos de cualquier inyección.
    'idcategoria', 'nombre'
    ];

    public function cargarDesdeRequest($request) {
        $this->idcategoria = $request->input('id') != "0" ? $request->input('id') : $this->idcategoria;
        $this->nombre = $request->input('txtNombre');
    }

    public function insertar()
    {
        $sql = "INSERT INTO categorias (
                nombre
            ) VALUES (?);";
        $result = DB::insert($sql, [
            $this->nombre
        ]);
        return $this->idcategoria = DB::getPdo()->lastInsertId();
    }
    
    public function guardar()
    {
        $sql = "UPDATE categorias SET
            nombre='$this->nombre'
            WHERE idcategoria=?";
        $affected = DB::update($sql, [$this->idcategoria]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM categorias WHERE
            idcategoria=?";
        $affected = DB::delete($sql, [$this->idcategoria]);
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                idcategoria,
                nombre
            FROM categorias ORDER BY nombre ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idCategoria)
    {
        $sql = "SELECT
                idcategoria,
                nombre
            FROM categorias WHERE idcategoria = $idCategoria";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcategoria = $lstRetorno[0]->idcategoria;
            $this->nombre = $lstRetorno[0]->nombre;
            return $this;
        }
        return null;
    }

}

?>