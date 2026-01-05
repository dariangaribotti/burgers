<?php 

namespace App\Entidades\Sistema; //Evitamos choques de nombre, el namespace los diferencia.

use DB; //Importa la fachada de base de datos
use Illuminate\Database\Eloquent\Model; //Son atajos para no escribir el código completo.

class Postulacion extends Model {

    protected $table = 'postulaciones';
    public $timestamps = false;

    protected $fillable = [ //Protege la base datos de cualquier inyección.
    'idpostulacion', 'nombre', 'apellido', 'celular', 'correo', 'curriculum'
    ];

    public function cargarDesdeRequest($request) {
        $this->idpostulacion = $request->input('id') != "0" ? $request->input('id') : $this->idpostulacion;
        $this->nombre = $request->input('txtNombre');
        $this->apellido = $request->input('txtApellido');
        $this->celular = $request->input('txtCelular') != "" ? $request->input('txtCelular') : 0;
        $this->correo = $request->input('txtCorreo');
        $this->curriculum = $request->input('txtCurriculum');
    }

    public function insertar()
    {
        $sql = "INSERT INTO postulaciones (
                idpostulacion,
                nombre,
                apellido,
                celular,
                correo,
                curriculum
            ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->idpostulacion,
            $this->nombre,
            $this->apellido,
            $this->celular,
            $this->correo,
            $this->curriculum,
        ]);
        return $this->idpostulacion = DB::getPdo()->lastInsertId();
    }
    
    public function guardar()
    {
        $sql = "UPDATE postulaciones SET
            nombre='$this->nombre',
            apellido='$this->apellido',
            celular='$this->celular',
            correo='$this->correo',
            curriculum='$this->curriculum'
            WHERE idpostulacion=?";
        $affected = DB::update($sql, [$this->idpostulacion]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM postulaciones WHERE
            idpostulacion=?";
        $affected = DB::delete($sql, [$this->idpostulacion]);
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                idpostulacion,
                nombre,
                apellido,
                celular,
                correo,
                curriculum
            FROM postulaciones ORDER BY nombre ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idPostulacion)
    {
        $sql = "SELECT
                idpostulacion,
                nombre,
                apellido,
                celular,
                correo,
                curriculum
            FROM postulaciones WHERE idpostulacion = $idPostulacion";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idpostulacion = $lstRetorno[0]->idpostulacion;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->celular = $lstRetorno[0]->celular;
            $this->correo = $lstRetorno[0]->correo;
            $this->curriculum = $lstRetorno[0]->curriculum;
            return $this;
        }
        return null;
    }

}

?>