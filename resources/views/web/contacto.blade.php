@extends("web.plantilla")
@section("contenido")
  <section class="book_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Contactarse
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            <form action="">
              <div>
                <input type="text" name="txtNombre" id="txtNombre" class="form-control" placeholder="Your Name" />
              </div>
              <div>
                <input type="email" name="txtEmail" id="txtEmail" class="form-control" placeholder="Your Email" />
              </div>
              <div>
                <input type="text" name="txtNumero" id="txtNumero" class="form-control" placeholder="Phone Number" />
              </div>
              <div>
                <textarea name="txtDescripcion" id="txtDescripcion" class="form-control" placeholder="Description"></textarea>
              </div>  
              <div class="btn_box">
                <button name="btnEnviar" id="btnEnviar">
                  ENVIAR
                <d/button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="map_container ">
            <div id="googleMap"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection