@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container list">
        <div class="row mt-2">
            <h1 class="text-black">Productos</h1>
        </div>
        <div class="row mt-3">
            <div class="col-8">
                @if ($products->count() <= 0)
                    <div class="alert alert-warning alert-dismissible fade show warning" role="alert">
                        <i class="bi bi-exclamation-circle me-2 fs-5"></i>
                        <strong class="message">No hay Productos para mostrar.</strong>
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
                <form action="{{ route('products.create') }}" method="POST">
                    @csrf
                    @method('GET')
                      <button type="submit" class="btn btn-primary btn-sm">Nuevo Producto</button>
                </form>
            </div>
        </div>
        <div class="row mt-3">
            <form class="d-flex flex-row form-inline py-2 col-5 gap-2" action="{{ route('products.index') }}" method="GET">
              <input class="form-control mr-sm-2" type="search" name="name" placeholder="Buscar por nombre" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0 col-3" type="submit">Buscar</button>
            </form>
            <div class="col-12">
                <table class="table table-striped table-hover table-bordered" id="dataTable">
                    <thead>
                    <tr>
                        <th class="no-sort">#</th>
                        <th>name</th>
                        <th>description</th>
                        <th>detalles</th>
                        <th>precio</th>
                        <th>Id Categoria</th>
                        <th>Tags</th>
                        <th>Etiqueta</th>
                        <th>Es Nuevo?</th>
                        <th>Se vende por Und.?</th>
                        <th>Stock Und.</th>
                        <th>Imagenes</th>
                        <th class="no-sort">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->details }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->category_id }}</td>
                                <td>{{ implode('|', json_decode($product->tags)) }}</td>
                                <th>{{ $product->label }}</th>
                                <td>{{ $product->is_new }}</td>
                                <td>{{ $product->is_unity }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm gap-2 d-flex flex-col" role="group">
                                        <a href="{{env('BACKEND_URL_IMAGE')}}{{ $product->image_url_1 }}" target="_blank">Imagen 1</a>
                                        @if ($product->image_2)
                                            <a href="{{env('BACKEND_URL_IMAGE')}}{{ $product->image_url_2 }}" target="_blank">Imagen 2</a>
                                        @endif
                                        @if ($product->image_3)
                                            <a href="{{env('BACKEND_URL_IMAGE')}}{{ $product->image_url_3 }}" target="_blank">Imagen 3</a>
                                        @endif
                                        @if ($product->image_4)
                                            <a href="{{env('BACKEND_URL_IMAGE')}}{{ $product->image_url_4 }}" target="_blank">Imagen 4</a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm gap-2" role="group">
                                        <form action="{{ route('products.edit', $product) }}" method="POST">
                                            @csrf
                                            @method('GET')
                                              <button type="submit" class="btn btn-secondary btn-sm">Editar</button>
                                        </form>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                              <button type="submit" class="btn btn-danger btn-sm">Borrar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="{{ route('products.index', ['page' => ($products->currentPage()-1)]) }}">Anterior</a></li>
                    @for ($i = 1; $i <= $products->lastPage(); $i++)
                      <li class="page-item{{ ($i == $products->currentPage()) ? ' active' : '' }}"><a class="page-link" href="{{ route('products.index', ['page' => $i]) }}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item"><a class="page-link" href="{{ route('products.index', ['page' => ($products->currentPage()+1)]) }}">Siguiente</a></li>
                  </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection


