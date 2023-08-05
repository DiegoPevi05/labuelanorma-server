@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
        @if ($giveaway)
            <div class="col-12">
                <h4 class="mb-3">Modificar Sorteo "{{ $giveaway->name }}"</h4>
                <form method="POST" action="{{ route('giveaways.update', $giveaway) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nombre del Sorteo </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $giveaway->name) }}">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Descripcion del Sorteo </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $giveaway->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="start_date">Comienzo del Sorteo</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $giveaway->start_date) }}">
                        @error('start_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="end_date">Fecha de Fin del Sorteo</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $giveaway->end_date) }}">
                        @error('end_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_winner_id">Identificador del usuario </label>
                        <input type="number" class="form-control @error('user_winner_id') is-invalid @enderror" id="user_winner_id" name="user_winner_id" min="0"  value="{{ old('user_winner_id', $giveaway->user_winner_id) }}">
                        @error('user_winner_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <p>Si reemplazas alguna imagen la anterior se eliminará</p>
                    <div class="form-group">
                        <div>
                            <label>Link de la actual imagen:</label>
                            <a href="{{env('BACKEND_URL_IMAGE')}}{{ $giveaway->image_url }}" target="_blank">Imagen 1</a>
                        </div>
                        <label for="image_1">Imagen del sorteo (Obligatoria)</label>
                        <input type="file" class="form-control @error('image_1') is-invalid @enderror" id="image_1" name="image_1">
                        @error('image_1')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Actualizar</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href="/giveaways" class="btn btn-secondary">Volver a la lista de Sorteos</a>
                </div>
            </div>
        @else
            <div class="row mt-3">
                <div class="row-5">
                    <div class="alert alert-danger" role="alert">
                        "Hubo un error al intentar traer la información del sorteo"
                    </div>
                    <a href="/giveaways" class="btn btn-primary">Voler a la lista</a>
                </div>
            </div>
        @endif
    </div>
@endsection


