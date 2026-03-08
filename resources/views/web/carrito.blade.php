@extends("web.plantilla")
@section("contenido")
<section>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center py-5">
                <h1>Carrito</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table-hover table table-borderless">
                  <thead>
                        <tr>
                              <td>Imagen</td>
                              <th>Numero</th>
                              <th>Precio</th>
                              <td>Eliminar</td>
                        </tr>
                  </thead>
                    <tbody>
                        <tr>
                              <th></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row ">
            <div class="col-12 py-4">
                <div class="btn_box pb-5">
                        <div class="ps-5">
                              <button type="submit" name="btnComprar" id="btnComprar" class="mr-4">COMPRAR</button>
                              <button type="submit" name="btnGuardar" id="btnGuardar" class="mr-4">VOLVER</button>
                        </div>
                  </div>
            </div>
        </div>
    </div>>
</section>
@endsection