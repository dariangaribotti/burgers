@extends("web.plantilla")
@section("contenido")
  <section class="food_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Nuestro menu
        </h2>
      </div>

      <ul class="filters_menu">
        <li class="active" data-filter="*">Todo</li>
        <li data-filter=".Hamburguesa">Hamburguesa</li>
        <li data-filter=".Pizza">Pizza</li>
        <li data-filter=".Pasta">Pasta</li>
        <li data-filter=".Papas">Papas</li>
      </ul>

      <div class="filters-content">
        <div class="row grid">
          @foreach($aProductos as $producto)
          @foreach($aCategorias as $categoria)
          <div class="col-sm-6 col-lg-4 all {{ $categoria->categoria }}">
          @endforeach
            <div class="box">
              <div>
                <div class="img-box">
                  <img src="{{ asset('files/' . $producto->imagen) }}" alt="">
                </div>
                <div class="detail-box">
                  <h5>
                    {{ $producto->nombre }}
                  </h5>
                  <p>
                    {{ $producto->descripcion }}
                  </p>
                  <div class="options">
                    <h6>
                      {{ $producto->precio }}
                    </h6>
                    <form action="POST">
                      <button type="submit">Agregar</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      <div class="btn-box">
        <a href="">
          Ver mas
        </a>
      </div>
    </div>
  </section>
@endsection