@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
        @if ($giveawayparticipant)
            <div class="col-12">
                <h4 class="mb-3">Modificar Participante de Sorteo</h4>
                <form method="POST" action="{{ route('giveawayparticipants.update', $giveawayparticipant) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="giveaway_id">Identificador del Sorteo </label>
                        <input type="number" class="form-control @error('giveaway_id') is-invalid @enderror" id="giveaway_id" name="giveaway_id" min="0"  value="{{ old('giveaway_id', $giveawayparticipant->giveaway_id) }}">
                        @error('giveaway_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_id">Identificador del usuario </label>
                        <input type="number" class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" min="0"  value="{{ old('user_id', $giveawayparticipant->user_id) }}">
                        @error('user_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Actualizar</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href="/giveawayparticipants" class="btn btn-secondary">Volver a la lista de Participantes</a>
                </div>
            </div>
        @else
            <div class="row mt-3">
                <div class="row-5">
                    <div class="alert alert-danger" role="alert">
                        "Hubo un error al intentar traer la información del participante del sorteo"
                    </div>
                    <a href="/giveawayparticipants" class="btn btn-primary">Voler a la lista de Participantes</a>
                </div>
            </div>
        @endif
    </div>
@endsection


