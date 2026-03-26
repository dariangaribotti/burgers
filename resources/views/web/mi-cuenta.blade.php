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
                            <input type="email" class="form-control" placeholder="Email" name="txtEmail" id="txtEmail" value="{{ $cliente->email }}" />
                        </div>
                        <div class="btn_box pb-5">
                            <div class="ps-5">
                                <button type="submit" name="btnRegistrarse" id="btnRegistrarse" class="mr-4">GUARDAR</button>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
        <div class="col-md-4 d-flex justify-content-center align-items-center">
            <div class="pb-5 pl-5">
                <table class="table table-hover table-borderless">
                    <thead>
                        <tr>
                            <th class="table orange">Pedidos</th>
                            <th class="table orange">Sucursal</th>
                            <th class="table orange">Estados</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aPedidos as $pedido)
                        <tr>
                            <td>{{$pedido->nombre}}</td>
                            <td>{{$pedido->sucursal}}</td>
                            <td>{{$pedido->estado}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>>
</section>
@endsection