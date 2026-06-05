@extends("web.plantilla")
@section('scripts')
<script>
    globalId = '<?php echo isset($cliente->idcliente) && $cliente->idcliente > 0 ? $cliente->idcliente : 0; ?>';
    <?php $globalId = isset($cliente->idcliente) ? $cliente->idcliente : "0"; ?>
</script>
@endsection
@section("contenido")
<div id="msg"></div>
<section class="book_section pt-5">
    <div class="container">
        <div class="heading_container">
            <h2>Registrarse</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                @if(isset($msg))
                <div class="alert alert-{{ $msg['ESTADO'] }} alert-dismissible" role="alert">
                    {{ $msg['MSG'] }}
                </div>
                @endif
                <div class="form_container justify-content-center">
                    <form action="/registrarse" method="POST">
                        @csrf
                        <div>
                            <input type="text" name="txtNombre" id="txtNombre" class="form-control" placeholder="Nombre" />
                        </div>
                        <div>
                            <input type="text" name="txtApellido" id="txtApellido" class="form-control" placeholder="Apellido" />
                        </div>
                        <div>
                            <input type="email" name="txtEmail" id="txtEmail" class="form-control" placeholder="Correo" />
                        </div>
                        <div>
                            <input type="text" name="txtDocumento" id="txtDocumento" class="form-control" placeholder="Documento" />
                        </div>
                        <div>
                            <input type="number" name="txtTelefono" id="txtTelefono" class="form-control" placeholder="Telefono" />
                        </div>
                        <div>
                            <input type="password" name="txtClave" id="txtClave" class="form-control" placeholder="Contraseña" />
                        </div>
                        <div class="btn_box pb-5">
                            <div class="ps-5">
                                <button type="submit" name="btnRegistrarse" id="btnRegistrarse" class="m-0 mr-4">REGISTRARSE</button>
                                <button type="button" name="btnVolver" id="btnVolver" class="m-0" onclick="window.history.back();">VOLVER</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection