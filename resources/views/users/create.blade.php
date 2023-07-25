@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
            <div class="col-12">
                <h4 class="mb-3">Nuevo Usuario</h4>
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="name">Nombre del Usuario </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Correo del Usuario </label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                            <option value="USER" selected>Usuario</option>
                            <option value="MODERATOR">Moderador</option>
                        </select>
                        @error('role')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Crear Usuario</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href="/users" class="btn btn-secondary">Volver a la lista de Usuarios</a>
                </div>
            </div>
    </div>
@endsection


