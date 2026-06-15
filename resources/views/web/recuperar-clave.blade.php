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
    <div class="container mb-5">
        <div class="mt-5">
            <h2>Restablecer contraseña</h2>
        </div>
        <div class="mb-5">
            <span>Ingresá tu correo electrónico asociado y te enviaremos los pasos para volver a ingresar a tu cuenta.</span>
        </div>
        <div class="row">
            <div class="col-md-6">
                @if(isset($msg))
                <div class="alert alert-{{ $msg['ESTADO'] }} alert-dismissible" role="alert">
                    {{ $msg['MSG'] }}
                </div>
                @endif
                <div class="form_container justify-content-center">
                    <form action="/recuperar-clave" method="POST">
                        @csrf
                        <div class="mb-5">
                            <input type="email" name="txtEmail" id="txtEmail" class="form-control" placeholder="Correo" required />
                        </div>
                        <!--<div>
                            <input type="password" name="txtClave1" id="txtClave1" class="form-control" placeholder="Contraseña" required />
                        </div>
                        <div>
                            <input type="password" name="txtClave2" id="txtClave2" class="form-control" placeholder="Repetir contraseña" required />
                        </div>
                        -->
                        <div class="btn_box pb-5 mb-5">
                            <div class="ps-5">
                                <button type="submit" name="btnRecuperar" id="btnRecuperar" class="m-0">RECUPERAR</button>
                                <button type="button" name="btnVolver" id="btnVolver" class="m-0 mx-2" onclick="window.history.back();">VOLVER</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection