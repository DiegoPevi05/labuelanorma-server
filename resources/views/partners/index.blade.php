@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container list">
        <div class="row mt-2">
            <h1 class="text-black">Partners</h1>
        </div>
        <div class="row mt-3">
            <div class="col-8">
                @if ($partners->count() <= 0)
                    <div class="alert alert-warning alert-dismissible fade show warning" role="alert">
                        <i class="bi bi-exclamation-circle me-2 fs-5"></i>
                        <strong class="message">No hay Partners para mostrar.</strong>
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
                <form action="{{ route('partners.create') }}" method="POST">
                    @csrf
                    @method('GET')
                      <button type="submit" class="btn btn-primary btn-sm">Nuevo Partner</button>
                </form>
            </div>
        </div>
        <div class="row mt-3">
            <form class="d-flex flex-row form-inline py-2 col-5 gap-2" action="{{ route('partners.index') }}" method="GET">
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
                        <th>Link Contenido</th>
                        <th>Pagina de Marca</th>
                        <th>Tags</th>
                        <th>Imagen de la marca</th>
                        <th class="no-sort">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($partners as $partner)
                            <tr>
                                <td>{{ $partner->id }}</td>
                                <td>{{ $partner->name }}</td>
                                <td>{{ $partner->description }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm gap-2 d-flex flex-col" role="group">
                                        <a href="{{ $partner->link_content }}" target="_blank">Link de contenido</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm gap-2 d-flex flex-col" role="group">
                                        <a href="{{ $partner->brand_link }}" target="_blank">Web/Ig de Marca</a>
                                    </div>
                                </td>
                                <td>{{ implode('|', json_decode($partner->tags)) }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm gap-2 d-flex flex-col" role="group">
                                        <a href="{{ $partner->image_brand }}" target="_blank">Imagen</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm gap-2" role="group">
                                        <form action="{{ route('partners.edit', $partner) }}" method="POST">
                                            @csrf
                                            @method('GET')
                                              <button type="submit" class="btn btn-secondary btn-sm">Editar</button>
                                        </form>
                                        <form action="{{ route('partners.destroy', $partner) }}" method="POST">
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
                    <li class="page-item"><a class="page-link" href="{{ route('partners.index', ['page' => ($partners->currentPage()-1)]) }}">Anterior</a></li>
                    @for ($i = 1; $i <= $partners->lastPage(); $i++)
                      <li class="page-item{{ ($i == $partners->currentPage()) ? ' active' : '' }}"><a class="page-link" href="{{ route('partners.index', ['page' => $i]) }}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item"><a class="page-link" href="{{ route('partners.index', ['page' => ($partners->currentPage()+1)]) }}">Siguiente</a></li>
                  </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection


