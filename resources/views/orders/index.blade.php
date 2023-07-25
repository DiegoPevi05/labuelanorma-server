@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container list">
        <div class="row mt-2">
            <h1 class="text-black">Ordenes</h1>
        </div>
        <div class="row mt-3">
            <div class="col-8">
                @if ($orders->count() <= 0)
                    <div class="alert alert-warning alert-dismissible fade show warning" role="alert">
                        <i class="bi bi-exclamation-circle me-2 fs-5"></i>
                        <strong class="message">No hay Ordenes para mostrar.</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show success" role="alert">
                        <i class="bi bi-check-circle me-2 fs-5"></i>
                        <strong class="message">{{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="col-4 text-end">
                <form action="{{ route('orders.create') }}" method="POST">
                    @csrf
                    @method('GET')
                      <button type="submit" class="btn btn-primary btn-sm">Generar nueva orden</button>
                </form>
            </div>
        </div>
        <div class="row mt-3">
            <form class="d-flex flex-row form-inline py-2 col-5 gap-2" action="{{ route('orders.index') }}" method="GET">
              <input class="form-control mr-sm-2" type="search" name="order_number" placeholder="Buscar por numero de orden" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0 col-3" type="submit">Buscar</button>
            </form>
            <div class="col-12">
                <table class="table table-striped table-hover table-bordered" id="dataTable">
                    <thead>
                    <tr>
                        <th class="no-sort">#</th>
                        <th>Numero de Orden</th>
                        <th>Id de Usuario</th>
                        <th>Estado</th>
                        <th>Codigo de Descuento</th>
                        <th>Importe Calculado?</th>
                        <th>Importe Bruto</th>
                        <th>Importe de Descuento</th>
                        <th>Importe Neto</th>
                        <th class="no-sort">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->user_id }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ $order->discount_code_id }}</td>
                                <td>{{ $order->calculated_amount }}</td>
                                <td>{{ $order->gross_import }}</td>
                                <td>{{ $order->discount_amount }}</td>
                                <td>{{ $order->net_import }}</td>

                                <td>
                                    <div class="btn-group btn-group-sm gap-2" role="group">
                                        <form action="{{ route('orders.edit', $order) }}" method="POST">
                                            @csrf
                                            @method('GET')
                                              <button type="submit" class="btn btn-secondary btn-sm">Editar</button>
                                        </form>
                                        <form action="{{ route('orders.destroy', $order) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                              <button type="submit" class="btn btn-danger btn-sm">Borrar</button>
                                        </form>
                                        <Button>Ver Items</Button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#</td>
                                <td>Id del Producto product_id</td>
                                <td>Id de Tall de Producto product_size_id</td>
                                <td>Cantidad quantity</td>
                                <td>Precio price</td>
                            </tr>
                            <tr>
                                @foreach ($orderItems as $orderItem)
                                    @if ($orderItem->order_id == $order->id)
                                        <td>{{ $orderItem->id }}</td>
                                        <td>{{ $orderItem->product_id }}</td>
                                        <td>{{ $orderItem->product_size_id }}</td>
                                        <td>{{ $orderItem->quantity }}</td>
                                        <td>{{ $orderItem->price }}</td>
                                     @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="{{ route('orders.index', ['page' => ($orders->currentPage()-1)]) }}">Anterior</a></li>
                    @for ($i = 1; $i <= $orders->lastPage(); $i++)
                      <li class="page-item{{ ($i == $orders->currentPage()) ? ' active' : '' }}"><a class="page-link" href="{{ route('orders.index', ['page' => $i]) }}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item"><a class="page-link" href="{{ route('orders.index', ['page' => ($orders->currentPage()+1)]) }}">Siguiente</a></li>
                  </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection


