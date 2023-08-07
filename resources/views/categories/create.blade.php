@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
            <div class="col-12">
                <h4 class="mb-3">Nueva Categoria</h4>
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="name">Nombre de la Categoria </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="section">Nombre de la Seccion de la Categoria </label>
                        <input type="text" class="form-control @error('section') is-invalid @enderror" id="section" name="section">
                        @error('section')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Crear Categoria</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href={{ route('categories.index') }} class="btn btn-secondary">Volver a la lista de Categorias</a>
                </div>
            </div>
    </div>
@endsection


