@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
        @if ($user)
            <div class="col-12">
                <h4 class="mb-3">Modificar Usuario "{{ $user->name }}"</h4>
                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nombre del Usuario </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Correo del Usuario </label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password', $user->password) }}">
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                            <option value="USER" {{$user->role == "USER" ? 'selected' : ''}}>Usuario</option>
                            <option value="MODERATOR" {{$user->role == "MODERATOR" ? 'selected' : ''}}>Moderador</option>
                        </select>
                        @error('role')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Actualizar</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href="/users" class="btn btn-secondary">Volver a la lista de Usuarios</a>
                </div>
            </div>
        @else
            <div class="row mt-3">
                <div class="row-5">
                    <div class="alert alert-danger" role="alert">
                        "Hubo un error al intentar traer la información usuario"
                    </div>
                    <a href="/users" class="btn btn-primary">Voler a la lista</a>
                </div>
            </div>
        @endif
    </div>
@endsection


