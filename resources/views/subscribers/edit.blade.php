@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
        @if ($subscriber)
            <div class="col-12">
                <h4 class="mb-3">Modificar Participante de Sorteo</h4>
                <form method="POST" action="{{ route('subscribers.update', $subscriber) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="user_id">Identificador del usuario </label>
                        <input type="number" class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" min="0"  value="{{ old('user_id', $subscriber->user_id) }}">
                        @error('user_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Actualizar</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href="/subscribers" class="btn btn-secondary">Volver a la lista de Subscriptores</a>
                </div>
            </div>
        @else
            <div class="row mt-3">
                <div class="row-5">
                    <div class="alert alert-danger" role="alert">
                        "Hubo un error al intentar traer la información del subscriptor"
                    </div>
                    <a href="/subscribers" class="btn btn-primary">Voler a la lista de Subscriptores</a>
                </div>
            </div>
        @endif
    </div>
@endsection


