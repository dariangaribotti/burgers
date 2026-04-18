<?php

namespace App\Entidades; //Evitamos choques de nombre, el namespace los diferencia.

use DB; //Importa la fachada de base de datos
use Illuminate\Database\Eloquent\Model; //Son atajos para no escribir el código completo.

class Cliente extends Model
{

    protected $table = 'clientes';
    public $timestamps = false;

    protected $fillable = [ //Protege la base datos de cualquier inyección.
        'idcliente',
        'nombre',
        'apellido',
        'correo',
        'dni',
        'celular',
        'clave'
    ];

    public function cargarDesdeRequest($request)
    {
        $this->idcliente = $request->input('id') != "0" ? $request->input('id') : $this->idcliente; //
        $this->nombre = $request->input('txtNombre');
        $this->apellido = $request->input('txtApellido');
        $this->correo = $request->input('txtCorreo');
        $this->dni = $request->input('txtDni');
        $this->celular = $request->input('txtCelular');
        $this->clave = $request->input('txtClave');
    }

    public function insertar()
    {
        $sql = "INSERT INTO clientes (
                nombre,
                apellido,
                correo,
                dni,
                celular,
                clave
            ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->nombre,
            $this->apellido,
            $this->correo,
            $this->dni,
            $this->celular,
            $this->clave,
        ]);
        return $this->idmenu = DB::getPdo()->lastInsertId();
    }

    public function registrarse(){
        $sql = "INSERT INTO clientes (
                correo,
                clave
            ) VALUES (?, ?);";
        $result = DB::insert($sql, [
            $this->correo,
            $this->clave
        ]);
        return $this->idmenu = DB::getPdo()->lastInsertId();
    }

    public function guardar()
    {
        $sql = "UPDATE clientes SET
            nombre='$this->nombre',
            apellido='$this->apellido',
            correo='$this->correo',
            dni='$this->dni',
            celular='$this->celular',
            clave='$this->clave'
            WHERE idcliente=?";
        $affected = DB::update($sql, [$this->idcliente]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM clientes WHERE
            idcliente=?";
        $affected = DB::delete($sql, [$this->idcliente]);
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                idcliente,
                nombre,
                apellido,
                correo,
                dni,
                celular,
                clave
            FROM clientes ORDER BY nombre ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idCliente)
    {
        $sql = "SELECT
                idcliente,
                nombre,
                apellido,
                correo,
                dni,
                celular,
                clave
            FROM clientes WHERE idcliente = $idCliente";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcliente = $lstRetorno[0]->idcliente;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->correo = $lstRetorno[0]->correo;
            $this->dni = $lstRetorno[0]->dni;
            $this->celular = $lstRetorno[0]->celular;
            $this->clave = $lstRetorno[0]->clave;
            return $this;
        }
        return null;
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'nombre',
            1 => 'apellido',
            2 => 'correo',
            3 => 'dni',
        );
        $sql = "SELECT DISTINCT
                    idcliente,
                    nombre,
                    apellido,
                    correo,
                    dni,
                    celular,
                    clave
                    FROM clientes
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR apellido LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR correo LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " OR dni LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerPorCorreo($correo)
    {
    $sql = "SELECT 
            idcliente, 
            correo, 
            clave FROM clientes WHERE correo = ?";
    $lstRetorno = DB::select($sql, [$correo]);
    // Si hay resultados, devolvemos el primero (el objeto con los 3 datos)
    return (count($lstRetorno) > 0) ? $lstRetorno[0] : null;
    }

    public function actualizarClave()
{
    $sql = "UPDATE clientes SET clave = ? WHERE idcliente = ?";
    $affected = DB::update($sql, [
        $this->clave,
        $this->idcliente
    ]);
}
}
