@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
            <div class="col-12">
                <h4 class="mb-3">Nuevo Contenido Web</h4>
                <form method="POST" action="{{ route('webcontents.store') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="section">Nombre de la Seccion de la web </label>
                        <input type="text" class="form-control @error('section') is-invalid @enderror" id="section" name="section" value="{{ old('section') }}">
                        @error('section')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="sub_section">Nombre de la Sub Seccion de la web </label>
                        <input type="text" class="form-control @error('sub_section') is-invalid @enderror" id="sub_section" name="sub_section" value="{{ old('sub_section') }}">
                        @error('sub_section')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content_type">Tipo de Contenido</label>
                        <select class="form-control @error('content_type') is-invalid @enderror" id="content_type" name="content_type">
                            <option {{ old('content_type') == 'image' ? 'selected="selected"' : '' }} value="image">Imagen</option>
                            <option {{ old('content_type') == 'text' ? 'selected="selected"' : '' }} value="text">Texto</option>
                            <option {{ old('content_type') == 'link' ? 'selected="selected"' : '' }} value="link">Enlace</option>
                        </select>
                        @error('content_type')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="content-link" class="form-group" style="display: none;">
                        <label for="content">Contenido de la Web (Enlace) </label>
                        <input type="text" class="form-control @error('content') is-invalid @enderror" id="link_content" name="content" value="{{ old('content') }}">
                        @error('content')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="content-text" class="form-group" style="display: none;">
                        <label for="content">Contenido de la Web (Texto) </label>
                        <textarea  class="form-control @error('content') is-invalid @enderror" id="text_content" name="content">{{ old('content') }}</textarea>
                        @error('content')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="content-file" class="form-group" style="display: none;">
                        <label for="content">Conteido Visua le la pagina</label>
                        <input type="file" class="form-control @error('content') is-invalid @enderror" id="file_content" name="content">
                        @error('content')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Crear Contenido Web</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href={{ route('webcontents.index') }} class="btn btn-secondary">Volver a la lista de Contenido Web</a>
                </div>
            </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // Function to show/hide the input elements based on the selected option
                function toggleContentFields() {
                    const selectedOption = $('#content_type').val();
                    if (selectedOption === 'text') {
                        $('#content-text').show();
                        $('#content-link').hide();
                        $('#content-file').hide();
                    } else if (selectedOption === 'link') {
                        $('#content-text').hide();
                        $('#content-link').show();
                        $('#content-file').hide();
                    } else if (selectedOption === 'image') {
                        $('#content-text').hide();
                        $('#content-link').hide();
                        $('#content-file').show();
                    } else {
                        // Hide all if none is selected (optional)
                        $('#content-text').hide();
                        $('#content-link').hide();
                        $('#content-file').hide();
                    }
                }

                // Call the function on page load
                toggleContentFields();

                // Call the function when the selection changes
                $('#content_type').change(function() {
                    toggleContentFields();
                });
            });
    </script>
@endsection

