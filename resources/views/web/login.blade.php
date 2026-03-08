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
                <div class="form_container justify-content-center">
                    <form action="" method="post">
                        <div>
                            <input type="text" class="form-control" placeholder="Usuario" />
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Contraseña" />
                        </div>
                        <div class="btn_box pb-5">
                            <div class="ps-5">
                                <button type="submit" name="btnIngresar" id="btnIngresar" class="mr-4 border-0">INGRESAR</button>
                                <button type="submit" name="btnRegistrarse" id="btnRegistrarse">REGISTRARSE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>>
</section>
@endsection