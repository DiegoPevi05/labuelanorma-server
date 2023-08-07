@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
        @if ($discountcode)
            <div class="col-12">
                <h4 class="mb-3">Modificar Codigo de Descuento: "{{ $discountcode->name }}"</h4>
                <form method="POST" action="{{ route('discountcodes.update', $discountcode) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nombre de Codigo de Descuento </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $discountcode->name) }}">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="discount">Descuento Aplicado en % </label>
                        <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" min="0"  value="{{ old('discount', $discountcode->discount) }}">
                        @error('discount')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="quantity_discounts">Cantida de descuentos</label>
                        <input type="number" class="form-control @error('quantity_discounts') is-invalid @enderror" id="quantity_discounts" name="quantity_discounts" min="0" value="{{ old('quantity_discounts', $discountcode->quantity_discounts) }}">
                        @error('quantity_discounts')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Producto a asignar</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                            <option {{ $discountcode->status == 'active' ? 'selected="selected"' : '' }} value="active">Activo</option>
                            <option {{ $discountcode->status == 'inactive' ? 'selected="selected"' : '' }} value="inactive">Inactive</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="expired_date">Cantida de descuentos</label>
                        <input type="date" class="form-control @error('expired_date') is-invalid @enderror" id="expired_date" name="expired_date" value="{{ $discountcode->expired_date }}">
                        @error('expired_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Actualizar</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href={{ route('discountcodes.index') }} class="btn btn-secondary">Volver a la lista de codigo de Descuentos</a>
                </div>
            </div>
        @else
            <div class="row mt-3">
                <div class="row-5">
                    <div class="alert alert-danger" role="alert">
                        "Hubo un error al intentar traer la información de los codigos de descuentos"
                    </div>
                    <a href={{ route('discountcodes.index') }} class="btn btn-primary">Voler a la lista</a>
                </div>
            </div>
        @endif
    </div>
@endsection


