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
            <h2>Registrarse</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form_container justify-content-center">
                    <form action="/registrarse" method="POST">
                        @csrf
                        <div>
                            <input type="text" name="txtNombre" id="txtNombre" class="form-control" placeholder="Nombre" required />
                        </div>
                        <div>
                            <input type="text" name="txtApellido" id="txtApellido" class="form-control" placeholder="Apellido" required />
                        </div>
                        <div>
                            <input type="email" name="txtEmail" id="txtEmail" class="form-control" placeholder="Correo" required />
                        </div>
                        <div>
                            <input type="text" name="txtDocumento" id="txtDocumento" class="form-control" placeholder="Documento" required />
                        </div>
                        <div>
                            <input type="number" name="txtTelefono" id="txtTelefono" class="form-control" placeholder="Telefono" required />
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