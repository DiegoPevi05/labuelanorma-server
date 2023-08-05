@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
            <div class="col-12">
                <h4 class="mb-3">Nueva Tall de Producto</h4>
                <form method="POST" action="{{ route('productsizes.store') }}">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="type">Tipo de Talla</label>
                        <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                            <option {{ old('type') == "Numerica" ? 'selected="selected"' : '' }} value="Numerica">Numerica</option>
                            <option {{ old('type') == "Numerico Romano" ? 'selected="selected"' : '' }} value="Numerico Romano">Numerico Romano</option>
                            <option {{ old('type') == "Unidad" ? 'selected="selected"' : '' }} value="Unidad">Unidad</option>
                        </select>
                        @error('type')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Nombre de Talla de Producto </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock del Producto</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" min="0" value="{{ old('stock',0) }}">
                        @error('stock')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Precio de la talla del producto </label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" min="0" step="any" value="{{ old('price',0) }}">
                        @error('price')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="product_id">Producto a asignar</label>
                        <select class="form-control @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
                            @foreach ($products as $product)
                                <option {{ old('product_id') == $product->id ? 'selected="selected"' : '' }} value="{{ $product->id }}">{{ $product->id . ": - " . $product->name }}</option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Crear Talla de Producto</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href="/productsizes" class="btn btn-secondary">Volver a la lista de Talla de Productos</a>
                </div>
            </div>
    </div>
@endsection


