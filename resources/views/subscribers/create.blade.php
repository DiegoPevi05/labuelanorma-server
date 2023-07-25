@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
            <div class="col-12">
                <h4 class="mb-3">Nuevo Subscriptor</h4>
                <form method="POST" action="{{ route('subscribers.store') }}">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="user_id">Identificador del usuario </label>
                        <input type="number" class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" min="0"  value="{{ old('user_id',0) }}">
                        @error('user_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Crear Subscriptor</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href="/subscribers" class="btn btn-secondary">Volver a la lista de Subscriptores</a>
                </div>
            </div>
    </div>
@endsection


