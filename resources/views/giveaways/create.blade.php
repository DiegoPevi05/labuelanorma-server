@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
            <div class="col-12">
                <h4 class="mb-3">Nuevo Sorteo</h4>
                <form method="POST" action="{{ route('giveaways.store') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="name">Nombre del Sorteo </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Descripcion del Sorteo </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="start_date">Comienzo del Sorteo</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}">
                        @error('start_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="end_date">Fecha de Fin del Sorteo</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}">
                        @error('end_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_winner_id">Identificador del usuario </label>
                        <input type="number" class="form-control @error('user_winner_id') is-invalid @enderror" id="user_winner_id" name="user_winner_id" min="0"  value="{{ old('user_winner_id',0) }}">
                        @error('user_winner_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image_1">Imagen del Sorteo (Obligatoria)</label>
                        <input type="file" class="form-control @error('image_1') is-invalid @enderror" id="image_1" name="image_1">
                        @error('image_1')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Crear Sorteo</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href={{ route('giveaways.index') }} class="btn btn-secondary">Volver a la lista de Sorteos</a>
                </div>
            </div>
    </div>
@endsection


