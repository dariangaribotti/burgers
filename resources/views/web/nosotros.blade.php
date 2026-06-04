@extends("web.plantilla")
@section("contenido")
  <section class="about_section layout_padding">
    <div class="container  ">

      <div class="row">
        <div class="col-md-6 ">
          <div class="img-box">
            <img src="web/images/about-img.png" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                Nosotros somos feane
              </h2>
            </div>
            <p>
              En Burgers, creemos que cada bocado debe ser una experiencia única. Utilizamos ingredientes frescos, carne de primera calidad y nuestras propias salsas secretas para asegurar el mejor sabor. Nuestra pasión por la parrilla nació en Buenos Aires y creció hasta formar una comunidad para amantes del sabor real. Vení a probar nuestra receta hoy mismo.
            </p>
            <a href="">
              Leer más
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <!-- client section -->

  <section class="client_section layout_padding-bottom">
    <div class="container">
      <div class="heading_container heading_center psudo_white_primary pb-3 pt-5">
        <h2>
          Lo que dicen nuestros clientes
        </h2>
      </div>
      <div class="carousel-wrap row ">
        <div class="owl-carousel client_owl-carousel">
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                </p>
                <h6>
                  Moana Michell
                </h6>
                <p>
                  magna aliqua
                </p>
              </div>
              <div class="img-box">
                <img src="web/images/client1.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                </p>
                <h6>
                  Mike Hamell
                </h6>
                <p>
                  magna aliqua
                </p>
              </div>
              <div class="img-box">
                <img src="web/images/client2.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end client section -->
   
  <!-- start form postulation -->
<section class="book_section layout_padding pt-4">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Trabaja con Nosotros
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6 mx-auto">
          @if(isset($msg))
            <div class="alert alert-{{ $msg['ESTADO'] }} alert-dismissible" role="alert">
                {{ $msg['MSG'] }}
            </div>
          @endif
          <div class="form_container">
            <form action="/nosotros" method="POST" enctype="multipart/form-data">
              @csrf
              <div>
                <input type="text" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre" />
              </div>
              <div>
                <input type="text" class="form-control" name="txtApellido" id="txtApellido" placeholder="Apellido" />
              </div>
              <div>
                <input type="number" class="form-control" name="txtCelular" id="txtCelular" placeholder="Celular" />
              </div>
              <div>
                <input type="email" class="form-control" name="txtCorreo" id="txtCorreo" placeholder="Correo" />
              </div>
              <div>
                <h6>Envíanos tu CV</h6>
                <input type="file" name="fileCurriculum" id="fileCurriculum" accept=".doc, .docx, .pdf" placeholder="Curriculum" />
                <small class="d-block">Archivos admitidos: .doc, .docx, .pdf</small>
              </div>
              <div class="btn_box d-flex justify-content-center">
                <button type="submit">POSTULARSE</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end form postulation -->
@endsection