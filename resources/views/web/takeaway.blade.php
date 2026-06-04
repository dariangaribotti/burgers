@extends("web.plantilla")
@section("contenido")
  <section class="food_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Nuestro menu
        </h2>
          @if(isset($msg))
            <div class="my-2 alert alert-{{ $msg['ESTADO'] }} alert-dismissible" role="alert">
                {{ $msg['MSG'] }}
            </div>
          @endif
      </div>

      <ul class="filters_menu">
        <li class="active" data-filter="*">Todo</li>
        @foreach($aCategorias as $categoria)
        <li data-filter=".{{ $categoria->nombre }}">{{ $categoria->nombre }}</li>
        @endforeach
      </ul>

      <div class="filters-content">
        <div class="row grid">
          @foreach($aProductos as $producto)
          <div class="col-sm-6 col-lg-4 all {{ $producto->categoria }}">
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
                      ${{ number_format($producto->precio, 0, ',', '.') }}
                    </h6>
                    <form action="/takeaway" method="POST">
                      @csrf
                      <input type="hidden" name="txtProducto" value="{{ $producto->idproducto }}">
                      <input type="number" name="txtCantidad" class="rounded" value="1" min="1" style="width: 50px; text-align: center;">
                      <button type="submit" name="btnAgregar" id="btnAgregar">Agregar</button>
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