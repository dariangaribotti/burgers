<?php 

namespace App\Entidades\Sistema; //Evitamos choques de nombre, el namespace los diferencia.

use DB; //Importa la fachada de base de datos
use Illuminate\Database\Eloquent\Model; //Son atajos para no escribir el código completo.

class Sucursal extends Model {

    protected $table = 'Sucursales';
    public $timestamps = false;

    protected $fillable = [ //Protege la base datos de cualquier inyección.
    'idsucursal', 'telefono', 'direccion', 'linkmapa'
    ];

    public function cargarDesdeRequest($request) {
        $this->idsucursal = $request->input('id') != "0" ? $request->input('id') : $this->idsucursal;
        $this->telefono = $request->input('txtTelefono');
        $this->direccion = $request->input('txtDireccion');
        $this->linkmapa = $request->input('txtMapa');
    }

    public function insertar()
    {
        $sql = "INSERT INTO sucursales (
                telefono,
                direccion,
                linkmapa
            ) VALUES (?, ?, ?);";
        $result = DB::insert($sql, [
            $this->telefono,
            $this->direccion,
            $this->linkmapa,
        ]);
        return $this->idsucursal = DB::getPdo()->lastInsertId();
    }
    
    public function guardar()
    {
        $sql = "UPDATE sucursales SET
            telefono='$this->telefono',
            direccion='$this->direccion',
            linkmapa='$this->linkmapa'
            WHERE idsucursal=?";
        $affected = DB::update($sql, [$this->idsucursal]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM sucursales WHERE
            idsucursal=?";
        $affected = DB::delete($sql, [$this->idsucursal]);
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                idsucursal,
                telefono,
                direccion,
                linkmapa
            FROM sucursales";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idSucursal)
    {
        $sql = "SELECT
                idsucursal,
                telefono,
                direccion,
                linkmapa
            FROM sucursales WHERE idsucursal = $idSucursal";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idsucursal = $lstRetorno[0]->idsucursal;
            $this->descripcion = $lstRetorno[0]->descripcion;
            $this->total = $lstRetorno[0]->total;
            $this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            $this->fk_idestado = $lstRetorno[0]->fk_idestado;
            return $this;
        }
        return null;
    }

}

?>