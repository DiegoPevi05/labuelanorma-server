@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container list">
        <div class="row mt-2">
            <h1 class="text-black">Contenido de la Web</h1>
        </div>
        <div class="row mt-3">
            <div class="col-8">
                @if ($webcontents->count() <= 0)
                    <div class="alert alert-warning alert-dismissible fade show warning" role="alert">
                        <i class="bi bi-exclamation-circle me-2 fs-5"></i>
                        <strong class="message">No Conteido de la web para mostrar.</strong>
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
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show error" role="alert">
                        <i class="bi bi-x-circle me-2 fs-5"></i>
                        <strong class="message">{{ session('error') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="col-4 text-end">
                <form action="{{ route('webcontents.create') }}" method="POST">
                    @csrf
                    @method('GET')
                      <button type="submit" class="btn btn-primary btn-sm">Nuevo Contenido web</button>
                </form>
            </div>
        </div>
        <div class="row mt-3">
            <form class="d-flex flex-row form-inline py-2 col-5 gap-2" action="{{ route('webcontents.index') }}" method="GET">
              <input class="form-control mr-sm-2" type="search" name="section" placeholder="Buscar por nombre de sección" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0 col-3" type="submit">Buscar</button>
            </form>
            <div class="col-12">
                <table class="table table-striped table-hover table-bordered" id="dataTable">
                    <thead>
                    <tr>
                        <th class="no-sort">#</th>
                        <th>Sección</th>
                        <th>SubSección</th>
                        <th>Tipo de Contenido</th>
                        <th>Contenido</th>
                        <th class="no-sort">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($webcontents as $webcontent)
                            <tr>
                                <td>{{ $webcontent->id }}</td>
                                <td>{{ $webcontent->section }}</td>
                                <td>{{ $webcontent->sub_section }}</td>
                                <td>{{ $webcontent->content_type }}</td>
                                @if ($webcontent->content_type == 'image')
                                    <td>
                                        <div class="btn-group btn-group-sm gap-2 d-flex flex-col" role="group">
                                            <a href="https://labuelanorma.com/server/public{{ $webcontent->content }}" target="_blank">Imagen 1</a>
                                        </div>
                                    </td>
                                @else
                                    <td>{{ $webcontent->content }}</td>
                                @endif
                                <td>
                                    <div class="btn-group btn-group-sm gap-2" role="group">
                                        <form action="{{ route('webcontents.edit', $webcontent) }}" method="POST">
                                            @csrf
                                            @method('GET')
                                              <button type="submit" class="btn btn-secondary btn-sm">Editar</button>
                                        </form>
                                        <form action="{{ route('webcontents.destroy', $webcontent) }}" method="POST">
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
                    <li class="page-item"><a class="page-link" href="{{ route('webcontents.index', ['page' => ($webcontents->currentPage()-1)]) }}">Anterior</a></li>
                    @for ($i = 1; $i <= $webcontents->lastPage(); $i++)
                      <li class="page-item{{ ($i == $webcontents->currentPage()) ? ' active' : '' }}"><a class="page-link" href="{{ route('webcontents.index', ['page' => $i]) }}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item"><a class="page-link" href="{{ route('webcontents.index', ['page' => ($webcontents->currentPage()+1)]) }}">Siguiente</a></li>
                  </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection


