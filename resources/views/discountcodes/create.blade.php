@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
            <div class="col-12">
                <h4 class="mb-3">Nuevo Codigo de Descuento</h4>
                <form method="POST" action="{{ route('discountcodes.store') }}">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="name">Nombre de Codigo de Descuento </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="discount">Descuento Aplicado en % </label>
                        <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" min="0"  value="{{ old('discount',0) }}">
                        @error('discount')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="quantity_discounts">Cantida de descuentos</label>
                        <input type="number" class="form-control @error('quantity_discounts') is-invalid @enderror" id="quantity_discounts" name="quantity_discounts" min="0" value="{{ old('quantity_discounts',0) }}">
                        @error('quantity_discounts')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Producto a asignar</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                            <option {{ old('status') == 'active' ? 'selected="selected"' : '' }} value="active">Activo</option>
                            <option {{ old('status') == 'inactive' ? 'selected="selected"' : '' }} value="inactive">Inactive</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="expired_date">Cantida de descuentos</label>
                        <input type="date" class="form-control @error('expired_date') is-invalid @enderror" id="expired_date" name="expired_date" value="{{ old('expired_date') }}">
                        @error('expired_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Crear Descuento</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href="/discountcodes" class="btn btn-secondary">Volver a la lista de Descuentos</a>
                </div>
            </div>
    </div>
@endsection


