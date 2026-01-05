<?php 

namespace App\Entidades\Sistema;

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
        $this->cantidad = $request->input('txtCantidad');
        $this->precio = $request->input('txtPrecio') != "" ? $request->input('txtPrecio') : 0;
        $this->imagen = $request->input('txtImagen');
        $this->fk_idcategoria = $request->input('txtCategoria');
    }

    public function insertar()
    {
        $sql = "INSERT INTO productos (
                nombre,
                cantidad,
                precio,
                imagen,
                fk_idcategoria,
            ) VALUES (?, ?, ?, ?, ?, ?);";
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
}

?>