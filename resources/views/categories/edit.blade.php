@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
        @if ($category)
            <div class="col-12">
                <h4 class="mb-3">Modificar Categoria "{{ $category->name }}"</h4>
                <form method="POST" action="{{ route('categories.update', $category) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nombre de la Categoria </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="section">Nombre de la Seccion de la Categoria </label>
                        <input type="text" class="form-control @error('section') is-invalid @enderror" id="section" name="section" value="{{ old('section', $category->section) }}">
                        @error('section')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Actualizar</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href="/categories" class="btn btn-secondary">Volver a la lista de Categorias</a>
                </div>
            </div>
        @else
            <div class="row mt-3">
                <div class="row-5">
                    <div class="alert alert-danger" role="alert">
                        "Hubo un error al intentar traer la información de la categoria"
                    </div>
                    <a href="/categories" class="btn btn-primary">Voler a la lista</a>
                </div>
            </div>
        @endif
    </div>
@endsection


