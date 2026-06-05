@extends("web.plantilla")
@section("contenido")
<section>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center py-5">
                <h1>Carrito</h1>
            </div>
        </div>
        @if(isset($msg))
        <div class="alert alert-{{ $msg['ESTADO'] }} alert-dismissible" role="alert">
            {{ $msg['MSG'] }}
        </div>
        @endif
        @if(isset($aCarritos))
        <div class="row">
            <div class="col-12">
                <table class="table-hover table table-borderless">
                    <thead>
                        <tr>
                            <th>nombre</th>
                            <th>precio</th>
                            <td>imagen</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aCarritos as $pos => $carrito)
                        <tr>
                            <th>{{$carrito->nombre}}</th>
                            <th>{{$carrito->precio}}</th>
                            <td><img src="{{ asset('files/' . $carrito->imagen) }}" alt="Imagen del producto" class="img-thumbnail" style="max-width: 150px;"></td>
                            <td></td>
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