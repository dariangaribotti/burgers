<?php 

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model {
      
    protected $table = 'productos';
    public $timestamps = false;

    protected $fillable = [
        'idproducto', 'nombre', 'cantidad', 'precio', 'imagen', 'fk_idcategoria'
    ];

    public function cargarDesdeRequest($request)
    {
        $this->idproducto = $request->input('id') != "0" ? $request->input('id') : $this->idproducto;
        $this->nombre = $request->input('txtNombre');
        $this->cantidad = $request->input('txtCantidad') != "" ? $request->input('txtCantidad') : 0;
        $this->precio = $request->input('txtPrecio') != "" ? $request->input('txtPrecio') : 0;
        $this->imagen = $request->input('fileImagen');
        $this->fk_idcategoria = $request->input('lstCategoria');
    }

    public function insertar()
    {
        $sql = "INSERT INTO productos (
                nombre,
                cantidad,
                precio,
                imagen,
                fk_idcategoria
            ) VALUES (?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->nombre,
            $this->cantidad,
            $this->precio,
            $this->imagen,
            $this->fk_idcategoria,
        ]);
        return $this->idproducto = DB::getPdo()->lastInsertId();
    }

    public function guardar()
    {
        $sql = "UPDATE productos SET
            nombre='$this->nombre',
            cantidad='$this->cantidad',
            precio=$this->precio,
            imagen='$this->imagen',
            fk_idcategoria=$this->fk_idcategoria
            WHERE idproducto=?";
        $affected = DB::update($sql, [$this->idproducto]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM productos WHERE
            idproducto=?";
        $affected = DB::delete($sql, [$this->idproducto]);
    }

    public function existeProductoAsociado($id)
    {
        $sql = "SELECT
                idproducto,
                nombre,
                cantidad,
                precio,
                imagen,
                fk_idcategoria
            FROM productos WHERE fk_idcategoria = $id";
        $lstRetorno = DB::select($sql);

        return (count($lstRetorno) > 0);
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                  idproducto,
                  nombre,
                  cantidad,
                  precio,
                  imagen,
                  fk_idcategoria
                FROM productos ORDER BY nombre ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idProducto)
    {
        $sql = "SELECT
                    idproducto,
                    nombre,
                    cantidad,
                    precio,
                    imagen,
                    fk_idcategoria
                FROM productos WHERE idproducto = $idProducto";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idproducto = $lstRetorno[0]->idproducto;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->cantidad = $lstRetorno[0]->cantidad;
            $this->precio = $lstRetorno[0]->precio;
            $this->imagen = $lstRetorno[0]->imagen;
            $this->fk_idcategoria = $lstRetorno[0]->fk_idcategoria;
            return $this;
        }
        return null;
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'nombre',
            1 => 'cantidad',
            2 => 'precio',
        );
        $sql = "SELECT DISTINCT
                    idproducto,
                    nombre,
                    cantidad,
                    precio,
                    imagen,
                    fk_idcategoria
                    FROM productos
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR cantidad LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR precio LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}

?>