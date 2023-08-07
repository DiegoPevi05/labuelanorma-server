@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
            <div class="col-12">
                <h4 class="mb-3">Nuevo Participante de Sorteo</h4>
                <form method="POST" action="{{ route('giveawayparticipants.store') }}">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="giveaway_id">Identificador del Sorteo </label>
                        <input type="number" class="form-control @error('giveaway_id') is-invalid @enderror" id="giveaway_id" name="giveaway_id" min="0"  value="{{ old('giveaway_id',0) }}">
                        @error('giveaway_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_id">Identificador del usuario </label>
                        <input type="number" class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" min="0"  value="{{ old('user_id',0) }}">
                        @error('user_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Crear Participante de sorteo</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href={{ route('giveawayparticipants.index') }} class="btn btn-secondary">Volver a la lista de Participante de sorteo</a>
                </div>
            </div>
    </div>
@endsection


