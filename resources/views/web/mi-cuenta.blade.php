@extends("web.plantilla")
@section("contenido")
<section class="book_section pt-5">
    <div class="container">
        <div class="heading_container">
            <h2>
                Mi cuenta
            </h2>
        </div>
        <form action="" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    @if(isset($msg))
                    <div class="alert alert-{{ $msg['ESTADO'] }} alert-dismissible" role="alert">
                        {{ $msg['MSG'] }}
                    </div>
                    @endif
                    <div class="form_container justify-content-center">
                        <div>
                            <label for="">Nombre</label>
                            <input type="text" class="form-control" placeholder="Nombre" name="txtNombre" id="txtNombre" value="{{ $cliente->nombre }}" />
                        </div>
                        <div>
                            <label for="">Apellido</label>
                            <input type="text" class="form-control" placeholder="Apellido" name="txtApellido" id="txtApellido" value="{{ $cliente->apellido }}" />
                        </div>
                        <div>
                            <label for="">Celular</label>
                            <input type="number" class="form-control" placeholder="Celular" name="txtCelular" id="txtCelular" value="{{ $cliente->celular }}" />
                        </div>
                        <div>
                            <label for="">Email</label>
                            <input type="email" class="form-control" placeholder="Email" name="txtEmail" id="txtEmail" value="{{ $cliente->correo }}" />
                        </div>
                        <div>
                            <label for="">Documento</label>
                            <input type="text" class="form-control" placeholder="Documento" name="txtDocumento" id="txtDocumento" value="{{ $cliente->dni }}" />
                        </div>
                        <div class="btn_box pb-5">
                            <div class="ps-5">
                                <button type="submit" name="btnRegistrarse" id="btnRegistrarse" class="mr-4">GUARDAR</button>
                                <a href="/cambiar-clave">CAMBIAR CLAVE</a>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
        <div class="d-flex justify-content-center align-items-center">
            <div class="pb-5">
                <div class="pb-4">
                    <h2>Estado del pedido</h2>
                </div>
                <table class="table table-hover table-borderless">
                    <thead style="background-color: #ffb72b;">
                        <tr>
                            <th>Sucursal</th>
                            <th>Pedido</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aPedidos as $pedido)
                            @if($pedido->estado != "Entregado")
                            <tr>
                                <td>{{$pedido->sucursal}}</td>
                                <td>{{$pedido->idpedido}}</td>
                                <td>{{$pedido->estado}}</td>
                                <td>{{$pedido->fecha}}</td>
                                <td>${{number_format($pedido->total, 0, ",", ".")}}</td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>>
</section>
@endsection