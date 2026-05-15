    @extends("web.plantilla")
    @section("contenido")
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex justify-content-center py-5">
                    <h1>Carrito</h1>
                </div>
            </div>
            @if($aCarritos)
            <div class="row">
                <div class="col-12">
                    <table class="table-hover table table-borderless">
                    <thead>
                            @foreach($aProductos as $producto)
                            <tr>
                                <td>imagen</td>
                                <th>nombre</th>
                                <th>precio</th>
                                <td>Eliminar</td>
                            </tr>
                            @endforeach
                    </thead>
                        <tbody>
                                @foreach($aProductos as $producto)
                            <tr>
                                <td>{{$producto->imagen}}</td>
                                <th>{{$producto->nombre}}</th>
                                <th>{{$producto->precio}}</th>
                                <td>Eliminar</td>
                            </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
                No hay productos seleccionados
            @endif
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