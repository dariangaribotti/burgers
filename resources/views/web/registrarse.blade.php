@extends("web.plantilla")
@section("contenido")
<section class="book_section pt-5">
    <div class="container">
        <div class="heading_container">
            <h2>Registrarse</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form_container justify-content-center">
                    @isset($msg)
                    <div class="alert alert-{{ $msg['ESTADO'] }} text-center" role="alert">
                        {{ $msg['MSG'] }}
                    </div>
                    @endisset
                    <form action="/registrarse" method="POST">
                        @csrf
                        <div>
                            <input type="email" name="txtEmail" id="txtEmail" class="form-control" placeholder="Correo" required />
                        </div>
                        <div>
                            <input type="password" name="txtClave" id="txtClave" class="form-control" placeholder="Contraseña" required />
                        </div>
                        <div class="btn_box pb-5">
                            <div class="ps-5">
                                <button type="submit" name="btnRegistrarse" id="btnRegistrarse" class="mr-4">REGISTRARSE</button>
                                <button type="button" name="btnVolver" id="btnVolver" onclick="window.history.back();">VOLVER</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection