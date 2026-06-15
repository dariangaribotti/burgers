@extends("web.plantilla")
@section("contenido")
<section class="bg-light pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 pt-5">
                <h2>Carrito</h2>
            </div>
        </div>
        @if(isset($msg))
        <div class="alert alert-{{ $msg['ESTADO'] }} alert-dismissible" role="alert">
            {{ $msg['MSG'] }}
        </div>
        @endif
        @if(isset($aCarritos))
        <div class="row gx-4">
            <div class="col-md-6 px-0">
                <div class="card px-3 h-100 shadow-sm">
                    <div class="card-body rounded overflow-auto" style="max-height: 60vh;">
                        @foreach($aCarritos as $carrito)
                        <table class="card table-hover table table-borderless shadow-sm">
                            <tr>
                                <td>
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ asset('files/' . $carrito->imagen) }}" alt="Imagen del producto" style="max-width: 90px;" class="rounded shadow-sm">
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark border border-light">
                                            {{$carrito->cantidad}}
                                        </span>
                                    </div>
                                </td>
                                <th class="w-100 px-3">
                                    {{$carrito->nombre}}<br>
                                    <small>{{$carrito->descripcion}}</small>
                                </th>
                                <th class="text-center align-middle">${{number_format($carrito->precio, 0, ',', '.')}}</th>
                                <td class="text-center align-middle px-3">
                                    <form action="/carrito" method="POST">
                                        @csrf
                                        <input type="hidden" name="txtCarrito" value="{{ $carrito->idcarrito }}">
                                        <button type="submit" class="btn" name="btnEliminar" id="btnEliminar" value="{{$carrito->idcarrito}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-x-fill" viewBox="0 0 16 16">
                                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M7.354 5.646 8.5 6.793l1.146-1.147a.5.5 0 0 1 .708.708L9.207 7.5l1.147 1.146a.5.5 0 0 1-.708.708L8.5 8.207 7.354 9.354a.5.5 0 1 1-.708-.708L7.793 7.5 6.646 6.354a.5.5 0 1 1 .708-.708" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </table>
                        @endforeach
                    </div>
                </div>
            </div>

            @else
            No hay productos seleccionados
            @endif
            <div class="col-md-5">
                <div class="card h-100">
                    <div class="btn_box p-4 shadow-sm">
                        <div class="pb-4">
                            <h5>Detalles del pago</h5>
                        </div>
                        <?php 
                        $total = 0;
                        foreach($aCarritos as $carrito){
                        $total += $carrito->precio * $carrito->cantidad;
                        }
                        ?>
                        <div class="pb-4">
                            <h2>Total: {{ number_format($total, 0, ",", ".") }}</h2>
                        </div>
                        <form action="/carrito" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="lstSucursal" class="form-label small d-block text-secondary">Sucursal de retiro:</label>
                                <select name="lstSucursal" id="lstSucursal" class="form-select w-100 bg-light">
                                    @foreach($aPedidos as $pedido)
                                    <option value="{{ $pedido->fk_idsucursal }}">{{ $pedido->sucursal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="lstMetodoPago" class="form-label small d-block text-start pt-5 text-secondary">Metodo de pago:</label>
                                <select name="lstMetodoPago" id="lstMetodoPago" class="form-select w-100 bg-light">
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Mercadopago">MercadoPago</option>
                                </select>
                            </div>
                            <div class="py-5">
                                <button type="submit" class="btn btn-warning" name="btnComprar" id="btnComprar">COMPRAR</button>
                                <a href="/takeaway" class="btn btn-outline-secondary mx-2">VOLVER</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>>
</section>
@endsection