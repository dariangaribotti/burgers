<?php 

namespace App\Entidades; //Evitamos choques de nombre, el namespace los diferencia.

use DB; //Importa la fachada de base de datos
use Illuminate\Database\Eloquent\Model; //Son atajos para no escribir el código completo.

class Sucursal extends Model {

    protected $table = 'sucursales';
    public $timestamps = false;

    protected $fillable = [ //Protege la base datos de cualquier inyección.
    'idsucursal', 'nombre', 'telefono', 'direccion', 'linkmapa'
    ];

    public function cargarDesdeRequest($request) {
        $this->idsucursal = $request->input('id') != "0" ? $request->input('id') : $this->idsucursal;
        $this->nombre = $request->input('txtNombre');
        $this->telefono = $request->input('txtTelefono');
        $this->direccion = $request->input('txtDireccion');
        $this->linkmapa = $request->input('txtMapa');
    }

    public function insertar()
    {
        $sql = "INSERT INTO sucursales (
                nombre,
                telefono,
                direccion,
                linkmapa
            ) VALUES (?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->nombre,
            $this->telefono,
            $this->direccion,
            $this->linkmapa 
        ]);
        return $this->idsucursal = DB::getPdo()->lastInsertId();
    }
    
    public function guardar()
    {
        $sql = "UPDATE sucursales SET
            nombre='$this->nombre',
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
                nombre,
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
                nombre,
                telefono,
                direccion,
                linkmapa
            FROM sucursales WHERE idsucursal = $idSucursal";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idsucursal = $lstRetorno[0]->idsucursal;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->telefono = $lstRetorno[0]->telefono;
            $this->direccion = $lstRetorno[0]->direccion;
            $this->linkmapa = $lstRetorno[0]->linkmapa;
            return $this;
        }
        return null;
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'nombre',
            1 => 'telefono',
            2 => 'direccion',
        );
        $sql = "SELECT DISTINCT
                    idsucursal,
                    nombre,
                    telefono,
                    direccion,
                    linkmapa
                    FROM sucursales
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR telefono LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR direccion LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}

?>