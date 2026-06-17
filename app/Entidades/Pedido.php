<?php 

namespace App\Entidades; //Evitamos choques de nombre, el namespace los diferencia.

use DB; //Importa la fachada de base de datos
use Illuminate\Database\Eloquent\Model; //Son atajos para no escribir el código completo.

class Pedido extends Model {

    protected $table = 'pedidos';
    public $timestamps = false;

    protected $fillable = [ //Protege la base datos de cualquier inyección.
    'idpedido', 'fecha', 'total', 'fk_idsucursal', 'fk_idcliente', 'fk_idestado'
    ];

    public function cargarDesdeRequest($request) {
        $this->idpedido = $request->input('id') != "0" ? $request->input('id') : $this->idpedido;
        $this->fecha = $request->input('txtFecha');
        $this->total = $request->input('txtTotal');
        $this->fk_idsucursal = $request->input('lstSucursal');
        $this->fk_idcliente = $request->input('lstCliente');
        $this->fk_idestado = $request->input('lstEstado');
        $this->pago = $request->input('lstPago');
    }

    public function insertar()
    {
        $sql = "INSERT INTO pedidos (
                fecha,
                total,
                fk_idsucursal,
                fk_idcliente,
                fk_idestado,
                pago
            ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->fecha,
            $this->total,
            $this->fk_idsucursal,
            $this->fk_idcliente,
            $this->fk_idestado,
            $this->pago
        ]);
        return $this->idpedido = DB::getPdo()->lastInsertId();
    }
    
    public function guardar()
    {
        $sql = "UPDATE pedidos SET
            fecha='$this->fecha',
            fk_idsucursal=$this->fk_idsucursal,
            fk_idcliente=$this->fk_idcliente,
            fk_idestado=$this->fk_idestado,
            pago='$this->pago'
            WHERE idpedido=?";
        $affected = DB::update($sql, [$this->idpedido]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM pedidos WHERE
            idpedido=?";
        $affected = DB::delete($sql, [$this->idpedido]);
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                fecha,
                total,
                fk_idsucursal,
                fk_idcliente,
                fk_idestado,
                pago
            FROM pedidos ORDER BY fecha ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idPedido)
    {
        $sql = "SELECT
                idpedido,
                fecha,
                total,
                fk_idsucursal,
                fk_idcliente,
                fk_idestado,
                pago
            FROM pedidos WHERE idpedido = $idPedido";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idpedido = $lstRetorno[0]->idpedido;
            $this->total = $lstRetorno[0]->total;
            $this->fecha = $lstRetorno[0]->fecha;
            $this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            $this->fk_idestado = $lstRetorno[0]->fk_idestado;
            $this->pago = $lstRetorno[0]->pago;
            return $this;
        }
        return null;
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'fk_idcliente',
            1 => 'fecha',
            2 => 'nombre',
            3 => 'total',
        );
        $sql = "SELECT DISTINCT
                    A.idpedido,
                    A.fecha,
                    A.total,
                    A.fk_idsucursal,
                    A.fk_idcliente,
                    A.fk_idestado,
                    A.pago,
                    B.nombre AS sucursal,
                    C.nombre AS cliente,
                    D.nombre AS estado
                    FROM pedidos A
                    INNER JOIN sucursales B ON A.fk_idsucursal = B.idsucursal
                    INNER JOIN clientes C ON A.fk_idcliente = C.idcliente
                    INNER JOIN estados D ON A.fk_idestado = D.idestado
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( fk_idcliente LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR fecha LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR total LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " OR pago LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerEstado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'fk_idcliente',
            1 => 'fecha',
            2 => 'total',
        );
        $sql = "SELECT DISTINCT
                    A.idpedido,
                    A.fecha,
                    A.total,
                    A.fk_idsucursal,
                    A.fk_idcliente,
                    A.fk_idestado,
                    pago,
                    B.nombre AS sucursal,
                    C.nombre AS cliente,
                    D.nombre AS estado
                    FROM pedidos A
                    INNER JOIN sucursales B ON A.fk_idsucursal = B.idsucursal
                    INNER JOIN clientes C ON A.fk_idcliente = C.idcliente
                    INNER JOIN estados D ON A.fk_idestado = D.idestado
                WHERE 1=1
                ";
        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function existePedidoAsociado($id)
    {
        $sql = "SELECT
                idpedido,
                fecha,
                total,
                fk_idsucursal,
                fk_idcliente,
                fk_idestado,
                pago
            FROM pedidos WHERE fk_idcliente = $id";
        $lstRetorno = DB::select($sql);

        return (count($lstRetorno) > 0);
    }

    public function existeSucursalAsociado($id)
    {
        $sql = "SELECT
                idpedido,
                fecha,
                total,
                fk_idsucursal,
                fk_idcliente,
                fk_idestado,
                pago
            FROM pedidos WHERE fk_idsucursal = $id";
        $lstRetorno = DB::select($sql);

        return (count($lstRetorno) > 0);
    }

    public function obtenerPorCliente($idCliente)
    {
        $sql = "SELECT 
                A.idpedido,
                A.fecha,
                A.total,
                A.fk_idsucursal,
                A.fk_idcliente,
                A.fk_idestado,
                A.pago,
                B.nombre AS sucursal,
                C.nombre AS cliente,
                D.nombre AS estado
                FROM pedidos A
                INNER JOIN sucursales B ON A.fk_idsucursal = B.idsucursal
                INNER JOIN clientes C ON A.fk_idcliente = C.idcliente
                INNER JOIN estados D ON A.fk_idestado = D.idestado
                WHERE fk_idcliente = '$idCliente'";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
}

?>