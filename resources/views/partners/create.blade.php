@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
            <div class="col-12">
                <h4 class="mb-3">Nuevo Partner</h4>
                <form method="POST" action="{{ route('partners.store') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="name">Nombre del Partner </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description"> Descripción del Partner </label>
                        <textarea  class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="link_content"> Enlace de Contenido (el Frame del video) </label>
                        <input type="text" class="form-control @error('link_content') is-invalid @enderror" id="link_content" name="link_content" value="{{ old('link_content') }}">
                        @error('link_content')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="brand_link"> Enlace de la Marca con la que se ha trabajado </label>
                        <input type="text" class="form-control @error('brand_link') is-invalid @enderror" id="brand_link" name="brand_link" value="{{ old('brand_link') }}">
                        @error('brand_link')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tags"> Etiquetas del Partner !Importante las etiquetas deben se separadas por "|"</label>
                        <textarea  class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags">{{ old('tags') }}</textarea>
                        @error('tags')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Imagen de la Marca (Obligatoria)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                        @error('image')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Crear Partner</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href="/partners" class="btn btn-secondary">Volver a la lista de Partners</a>
                </div>
            </div>
    </div>
@endsection


