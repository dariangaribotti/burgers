@extends("web.plantilla")
@section("contenido")
<section class="book_section pt-5">
    <div class="container">
        <div class="heading_container">
            <h2>
                Login
            </h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                @if(isset($msg))
                <div class="alert alert-{{ $msg['ESTADO'] }} alert-dismissible" role="alert">
                    {{ $msg['MSG'] }}
                </div>
                @endif
                <div class="form_container justify-content-center">
                    <form action="/login" method="post">
                        @csrf
                        <div>
                            <input type="email" name="txtEmail" id="txtEmail" class="form-control" placeholder="Correo" />
                        </div>
                        <div>
                            <input type="password" name="txtClave" id="txtClave" class="form-control" placeholder="Contraseña" />
                        </div>
                        <div class="btn_box pb-4">
                            <div class="ps-2 justify-content-center align-items-center">
                                <button type="submit" name="btnIngresar" id="btnIngresar" class="m-0 border-0">INGRESAR</button>
                            </div>
                        </div>
                    </form>
                    <div class="pt-0 pb-2">
                        <span>¿Todavía no te registraste?</span>
                        <a href="/registrarse" style="all: unset; cursor: pointer; color: #0000ee;">Registrarse</a>
                    </div>
                    <div class="pt-0 pb-2">
                        <span>¿Olvidaste tu clave?</span>
                        <a href="/recuperar-clave" style="all: unset; cursor: pointer; color: #0000ee;">Recuperar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>>
</section>
@endsection