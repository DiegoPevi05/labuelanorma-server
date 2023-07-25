@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container list">
        <div class="row mt-2">
            <h1 class="text-black">Codigo de Descuentos</h1>
        </div>
        <div class="row mt-3">
            <div class="col-8">
                @if ($discountcodes->count() <= 0)
                    <div class="alert alert-warning alert-dismissible fade show warning" role="alert">
                        <i class="bi bi-exclamation-circle me-2 fs-5"></i>
                        <strong class="message">No hay codigo de descuentos para mostrar.</strong>
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
                <form action="{{ route('discountcodes.create') }}" method="POST">
                    @csrf
                    @method('GET')
                      <button type="submit" class="btn btn-primary btn-sm">Nuevo codigo de Descuento</button>
                </form>
            </div>
        </div>
        <div class="row mt-3">
            <form class="d-flex flex-row form-inline py-2 col-5 gap-2" action="{{ route('discountcodes.index') }}" method="GET">
              <input class="form-control mr-sm-2" type="search" name="name" placeholder="Buscar por nombre" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0 col-3" type="submit">Buscar</button>
            </form>
            <div class="col-12">
                <table class="table table-striped table-hover table-bordered" id="dataTable">
                    <thead>
                    <tr>
                        <th class="no-sort">#</th>
                        <th>Nombre</th>
                        <th>Descuento %</th>
                        <th>Cantidad de descuentos</th>
                        <th>Estado</th>
                        <th>Fecha de Expiracion</th>
                        <th class="no-sort">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($discountcodes as $discountcode)
                            <tr>
                                <td>{{ $discountcode->id }}</td>
                                <td>{{ $discountcode->name }}</td>
                                <td>{{ $discountcode->discount }}</td>
                                <td>{{ $discountcode->quantity_discounts }}</td>
                                <td>{{ $discountcode->status }}</td>
                                <td>{{ $discountcode->expired_date }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm gap-2" role="group">
                                        <form action="{{ route('discountcodes.edit', $discountcode) }}" method="POST">
                                            @csrf
                                            @method('GET')
                                              <button type="submit" class="btn btn-secondary btn-sm">Editar</button>
                                        </form>
                                        <form action="{{ route('discountcodes.destroy', $discountcode) }}" method="POST">
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
                    <li class="page-item"><a class="page-link" href="{{ route('discountcodes.index', ['page' => ($discountcodes->currentPage()-1)]) }}">Anterior</a></li>
                    @for ($i = 1; $i <= $discountcodes->lastPage(); $i++)
                      <li class="page-item{{ ($i == $discountcodes->currentPage()) ? ' active' : '' }}"><a class="page-link" href="{{ route('discountcodes.index', ['page' => $i]) }}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item"><a class="page-link" href="{{ route('discountcodes.index', ['page' => ($discountcodes->currentPage()+1)]) }}">Siguiente</a></li>
                  </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection


