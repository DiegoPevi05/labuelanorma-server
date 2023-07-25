@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container list">
        <div class="row mt-2">
            <h1 class="text-black">Subscriptores</h1>
        </div>
        <div class="row mt-3">
            <div class="col-8">
                @if ($subscribers->count() <= 0)
                    <div class="alert alert-warning alert-dismissible fade show warning" role="alert">
                        <i class="bi bi-exclamation-circle me-2 fs-5"></i>
                        <strong class="message">No hay subscriptores para mostrar.</strong>
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
                <form action="{{ route('subscribers.create') }}" method="POST">
                    @csrf
                    @method('GET')
                      <button type="submit" class="btn btn-primary btn-sm">Crear Nuevo Participante de sorteo</button>
                </form>
            </div>
        </div>
        <div class="row mt-3">
            <form class="d-flex flex-row form-inline py-2 col-5 gap-2" action="{{ route('subscribers.index') }}" method="GET">
              <input class="form-control mr-sm-2" type="search" name="userid" placeholder="Buscar por identificador de Usuario" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0 col-3" type="submit">Buscar</button>
            </form>
            <div class="col-12">
                <table class="table table-striped table-hover table-bordered" id="dataTable">
                    <thead>
                    <tr>
                        <th class="no-sort">#</th>
                        <th>Identificador de Usuario</th>
                        <th class="no-sort">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscribers as $subscriber)
                            <tr>
                                <td>{{ $subscriber->id }}</td>
                                <td>{{ $subscriber->user_id }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm gap-2" role="group">
                                        <form action="{{ route('subscribers.edit', $subscriber) }}" method="POST">
                                            @csrf
                                            @method('GET')
                                              <button type="submit" class="btn btn-secondary btn-sm">Editar</button>
                                        </form>
                                        <form action="{{ route('subscribers.destroy', $subscriber) }}" method="POST">
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
                    <li class="page-item"><a class="page-link" href="{{ route('subscribers.index', ['page' => ($subscribers->currentPage()-1)]) }}">Anterior</a></li>
                    @for ($i = 1; $i <= $subscribers->lastPage(); $i++)
                      <li class="page-item{{ ($i == $subscribers->currentPage()) ? ' active' : '' }}"><a class="page-link" href="{{ route('subscribers.index', ['page' => $i]) }}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item"><a class="page-link" href="{{ route('subscribers.index', ['page' => ($subscribers->currentPage()+1)]) }}">Siguiente</a></li>
                  </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection


