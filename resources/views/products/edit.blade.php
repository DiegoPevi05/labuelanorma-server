@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
        @if ($product)
            <div class="col-12">
                <h4 class="mb-3">Modificar Usuario "{{ $product->name }}"</h4>
                <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nombre del Producto </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description"> Descripción del Producto </label>
                        <textarea  class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="details"> Detalles del Producto </label>
                        <textarea  class="form-control @error('details') is-invalid @enderror" id="details" name="details">{{ old('details', $product->details) }}</textarea>
                        @error('details')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Precio del Producto </label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" min="0" step="any" value="{{ old('price', $product->price) }}">
                        @error('price')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tags"> Etiquetas del Producto !Importante las etiquetas deben se separadas por "|"</label>
                        <textarea  class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags">{{ old('tags', implode('|', json_decode($product->tags))) }}</textarea>
                        @error('tags')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="label">Etiqueta del Producto</label>
                        <select class="form-control @error('label') is-invalid @enderror" id="label" name="label">
                            <option {{ $product->label == 'Ninguno' ? 'selected="selected"' : '' }} value="Ninguno">Ninguno</option>
                            <option {{ $product->label == 'Novedades' ? 'selected="selected"' : '' }} value="Novedades">Novedades</option>
                            <option {{ $product->label == 'DeEpoca' ? 'selected="selected"' : '' }} value="DeEpoca">DeEpoca</option>
                        </select>
                        @error('label')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="is_new">El producto es nuevo?</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input @error('is_new') is-invalid @enderror" id="is_new" name="is_new" {{ old('is_new', $product->is_new) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_new">Yes</label>
                        </div>
                        @error('is_new')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="is_unity">El producto se vende por unidad o talla?</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input @error('is_unity') is-invalid @enderror" id="is_unity" name="is_unity" {{ old('is_unity', $product->is_unity) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_unity">Yes</label>
                        </div>
                        @error('is_unity')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock del Producto si se vende por unidad</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" min="0" value="{{ old('stock',$product->stock) }}">
                        @error('stock')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category_id">Categoria del Producto</label>
                        <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                            @foreach ($categories as $category)
                                <option {{ $product->category_id == $category->id ? 'selected="selected"' : '' }} value="{{ $category->id }}">{{ $category->name . " - " . $category->section }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <h3>Si reemplazas alguna imagen la anterior se eliminará</h3>
                    <div class="form-group">
                        <div>
                            <label>Link de la actual imagen 1:</label>
                            <a href="{{env('BACKEND_URL_IMAGE')}}{{ $product->image_url_1 }}" target="_blank">Imagen 1</a>
                        </div>
                        <label for="image_1">Imagen 1 del Producto (Obligatoria)</label>
                        <input type="file" class="form-control @error('image_1') is-invalid @enderror" id="image_1" name="image_1">
                        @error('image_1')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div>
                        @if ($product->image_2)
                            <label>Link de la actual imagen 2:</label>
                            <a href="{{env('BACKEND_URL_IMAGE')}}{{ $product->image_url_2 }}" target="_blank">Imagen 2</a>
                        @else
                            <label>Imagen 2 no cargada</label>
                        @endif
                        </div>
                        <label for="image_2">Imagen 2 del Producto (Opcional)</label>
                        <input type="file" class="form-control @error('image_2') is-invalid @enderror" id="image_2" name="image_2">
                        @error('image_2')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div>
                        @if ($product->image_3)
                            <label>Link de la actual imagen 3:</label>
                            <a href="{{env('BACKEND_URL_IMAGE')}}{{ $product->image_url_3 }}" target="_blank">Imagen 3</a>
                        @else
                            <label>Imagen 3 no cargada</label>
                        @endif
                        </div>
                        <label for="image_3">Imagen 3 del Producto (Opcional)</label>
                        <input type="file" class="form-control @error('image_3') is-invalid @enderror" id="image_3" name="image_3">
                        @error('image_3')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div>
                        @if ($product->image_4)
                            <label>Link de la actual imagen 4:</label>
                            <a href="{{env('BACKEND_URL_IMAGE')}}{{ $product->image_url_4 }}" target="_blank">Imagen 4</a>
                        @else
                            <label>Imagen 4 no cargada</label>
                        @endif
                        </div>
                        <label for="image_4">Imagen 4 del Producto (Opcional)</label>
                        <input type="file" class="form-control @error('image_4') is-invalid @enderror" id="image_4" name="image_4">
                        @error('image_4')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Actualizar</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href="/products" class="btn btn-secondary">Volver a la lista de Productos</a>
                </div>
            </div>
        @else
            <div class="row mt-3">
                <div class="row-5">
                    <div class="alert alert-danger" role="alert">
                        "Hubo un error al intentar traer la información del Producto"
                    </div>
                    <a href="/products" class="btn btn-primary">Voler a la lista</a>
                </div>
            </div>
        @endif
    </div>
@endsection


