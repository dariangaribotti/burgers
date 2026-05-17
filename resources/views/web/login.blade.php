@extends("web.plantilla")
@section("contenido")

<?php
if (isset($msg)) {
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div id = "msg"></div>
<section class="book_section pt-5">
    <div class="container">
        <div class="heading_container">
            <h2>
                Login
            </h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form_container justify-content-center">
                    <form action="/login" method="post">
                        @csrf
                        <div>
                            <input type="email" class="form-control" placeholder="Correo" />
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Contraseña" />
                        </div>
                        <div class="btn_box pb-5">
                            <div class="ps-5">
                                <button type="submit" name="btnIngresar" id="btnIngresar" class="mr-4 border-0">INGRESAR</button>
                                <a href="/registrarse" name="btnRegistrarse" id="btnRegistrarse" class="mr-4 border-0">REGISTRARSE</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>>
</section>
@endsection