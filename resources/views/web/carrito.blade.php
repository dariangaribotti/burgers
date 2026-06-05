@extends("web.plantilla")
@section("contenido")
<section>
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
                    <div class="card-body rounded">
                        @foreach($aCarritos as $pos => $carrito)
                        <table class="card table-hover table table-borderless shadow-sm">
                            <tr>
                                <td><img src="{{ asset('files/' . $carrito->imagen) }}" alt="Imagen del producto" style="max-width: 90px;"></td>
                                <th class="w-100">
                                    {{$carrito->nombre}}<br>
                                    <small>{{$carrito->descripcion}}</small>
                                </th>
                                <th>${{number_format($carrito->precio, 0, ',', '.')}}</th>
                                <td><a href="/carrito?=pos">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-x-fill" viewBox="0 0 16 16">
                                            <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M7.354 5.646 8.5 6.793l1.146-1.147a.5.5 0 0 1 .708.708L9.207 7.5l1.147 1.146a.5.5 0 0 1-.708.708L8.5 8.207 7.354 9.354a.5.5 0 1 1-.708-.708L7.793 7.5 6.646 6.354a.5.5 0 1 1 .708-.708" />
                                        </svg>
                                    </a>
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
                <div class="card">
                    <div class="btn_box p-4 h-100 shadow-sm">
                        <div class="pb-4">
                            <h5>Detalles del pago</h5>
                        </div>
                        <form action="/carrito" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="lstSucursal" class="form-label small d-block">Sucursal de retiro:</label>
                                <select name="lstSucursal" class="form-select w-100" id="lstSucursal">
                                    @foreach($aPedidos as $pedido)
                                    <option value="{{ $pedido->idpedido }}">{{ $pedido->sucursal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="lstMetodoPago" class="form-label small d-block text-start pt-5">Metodo de pago:</label>
                                <select name="lstMetodoPago" class="form-select w-100" id="lstSucursal">
                                    <option value="efectivo">Efectivo</option>
                                    <option value="mercadopago">Mercado Pago</option>
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