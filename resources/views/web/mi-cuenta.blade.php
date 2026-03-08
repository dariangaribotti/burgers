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
            <div class="row">
                <div class="col-md-6">
                    <div class="form_container justify-content-center">

                        <div>
                            <label for="">Nombre</label>
                            <input type="text" class="form-control" placeholder="Nombre" />
                        </div>
                        <div>
                            <label for="">Apellido</label>
                            <input type="text" class="form-control" placeholder="Apellido" />
                        </div>
                        <div>
                            <label for="">Celular</label>
                            <input type="number" class="form-control" placeholder="Celular" />
                        </div>
                        <div>
                            <label for="">Email</label>
                            <input type="email" class="form-control" placeholder="Email" />
                        </div>
                        <div class="btn_box pb-5">
                            <div class="ps-5">
                                <button type="submit" name="btnRegistrarse" id="btnRegistrarse" class="mr-4">GUARDAR</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 d-flex justify-content-center align-items-center">
                    <div class="form_container pb-5 pl-5">
                        <table class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th class="table orange">Pedidos</th>
                                    <th class="table orange">Estados</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aPedidos as $pedido)
                                <tr>
                                    <td>{{$pedido->nombre}}</td>
                                    <td>{{$pedido->estado}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>>
</section>
@endsection