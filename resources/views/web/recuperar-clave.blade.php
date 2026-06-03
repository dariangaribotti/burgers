@extends("web.plantilla")
@section('scripts')
<script>
    globalId = '<?php echo isset($cliente->idcliente) && $cliente->idcliente > 0 ? $cliente->idcliente : 0; ?>';
    <?php $globalId = isset($cliente->idcliente) ? $cliente->idcliente : "0"; ?>
</script>
@endsection
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
            <h2>Recuperar clave</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form_container justify-content-center">
                    <form action="/recuperar-clave" method="POST">
                        @csrf
                        <div>
                            <input type="email" name="txtEmail" id="txtEmail" class="form-control" placeholder="Correo" required />
                        </div>
                        <div>
                            <input type="password" name="txtClave" id="txtClave" class="form-control" placeholder="Contraseña" required />
                        </div>
                        <div>
                            <input type="password" name="txtClave" id="txtClave" class="form-control" placeholder="Repetir contraseña" required />
                        </div>
                        <div class="btn_box pb-5">
                            <div class="ps-5">
                                <button type="submit" name="btnRecuperar" id="btnRecuperar" class="mr-4">RECUPERAR</button>
                                <button type="button" name="btnVolver" id="btnVolver" onclick="window.history.back();">VOLVER</button>
                            </div>
                        </div>
                         <div class="btn_box pb-5">
                            <div class="d-flex align-items-center">
                                <h2 class="mb-0 mr-2">No tenes cuenta?</h2>
                                <a href="/registrarse">REGISTRATE</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection