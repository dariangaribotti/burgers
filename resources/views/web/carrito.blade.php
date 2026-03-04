@extends("web.plantilla")
@section("contenido")
<div class="container">
    <div class="row">
        <div class="col-md-6 d-flex justify-content-center py-5">
            <h1>Carrito</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <table class="table-hover table">
                <tr>
                    <td>Imagen</td>
                    <th>Burger</th>
                    <th>Numero</th>
                    <th>Precio</th>
                    <td>Eliminar</td>
                </tr>
                <tr>
                    <td>Imagen</td>
                    <th>Burger</th>
                    <th>Numero</th>
                    <th>Precio</th>
                    <td>Eliminar</td>
                </tr>
                <tr>
                    <td>Imagen</td>
                    <th>Burger</th>
                    <th>Numero</th>
                    <th>Precio</th>
                    <td>Eliminar</td>
                </tr>
            </table>
        </div>
        <div class="col-md-3">
            <button type="submit">COMPRAR</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12 py-4">
            <a href="/takeaway" class="text-reset text-decoration-none">Volver al inicio</a>
        </div>
    </div>
</div>
@endsection