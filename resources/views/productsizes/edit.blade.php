@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
        @if ($productsize)
            <div class="col-12">
                <h4 class="mb-3">Modificar Talla de Producto "{{ $productsize->name }}"</h4>
                <form method="POST" action="{{ route('productsizes.update', $productsize) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="type">Tipo de Talla</label>
                        <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                            <option {{ $productsize->type== "Numerica" ? 'selected="selected"' : '' }} value="Numerica">Numerica</option>
                            <option {{ $productsize->type == "Numerico Romano" ? 'selected="selected"' : '' }} value="Numerico Romano">Numerico Romano</option>
                            <option {{ $productsize->type == "Unidad" ? 'selected="selected"' : '' }} value="Unidad">Unidad</option>
                        </select>
                        @error('type')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Nombre de Talla de Producto </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $productsize->name) }}">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock del Producto</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" min="0" value="{{ old('stock', $productsize->stock) }}">
                        @error('stock')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Precio de la talla del producto </label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" min="0" step="any" value="{{ old('price',$productsize->price) }}">
                        @error('price')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="product_id">Producto a asignar</label>
                        <select class="form-control @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
                            @foreach ($products as $product)
                                <option {{ $productsize->product_id == $product->id ? 'selected="selected"' : '' }} value="{{ $product->id }}">{{ $product->id . ": - " . $product->name }}</option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Actualizar</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href="/productsizes" class="btn btn-secondary">Volver a la lista de Tallas de Productos</a>
                </div>
            </div>
        @else
            <div class="row mt-3">
                <div class="row-5">
                    <div class="alert alert-danger" role="alert">
                        "Hubo un error al intentar traer la información de la Talla de Producto"
                    </div>
                    <a href="/productsizes" class="btn btn-primary">Voler a la lista</a>
                </div>
            </div>
        @endif
    </div>
@endsection


