@extends('layouts.app')

@section('content')
    <div class="container-fluid main-container">
            <div class="col-12">
                <h4 class="mb-3">Nueva Orden</h4>
                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf
                    @method('POST')
                    @if ($discountcodes && count($discountcodes) > 0)
                        <div class="form-group">
                            <label for="discount_code_id">Codigos de Descuento</label>
                            <select class="form-control @error('discount_code_id') is-invalid @enderror" id="discount_code_id" name="discount_code_id">
                                @foreach ($discountcodes as $discountcode)
                                    <option {{ old('discount_code_id') == $discountcode->id ? 'selected="selected"' : '' }} value="{{ $discountcode->id }}">{{ $discountcode->id . ": - " . $discountcode->name }}</option>
                                @endforeach
                            </select>
                            @error('discount_code_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    @else
                        <label for="type" class="my-2 text-success">No hay codigos de Descuento para aplicar </label>
                    @endif

                    <div class="form-group">
                        <label>Calcular importe bruto</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('calculated_amount') is-invalid @enderror" type="radio" name="calculated_amount" id="calculated_amount_true" value="1" {{ old('calculated_amount', 'false') == 'true' ? '' : 'checked' }}>
                            <label class="form-check-label" for="calculated_amount_true">Calculado</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('calculated_amount') is-invalid @enderror" type="radio" name="calculated_amount" id="calculated_amount_false" value="0" {{ old('calculated_amount', 'false') == 'true' ? '' : 'checked' }}>
                            <label class="form-check-label" for="calculated_amount_false">No Calculado</label>
                        </div>
                        @error('calculated_amount')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="gross_import">Importe Bruto Total </label>
                        <input type="number" class="form-control @error('gross_import') is-invalid @enderror" id="gross_import" name="gross_import" min="0" step="any" value="{{ old('gross_import',0) }}">
                        @error('gross_import')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Estado de la Orden</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                <option {{ old('status') == 'pending' ? 'selected="selected"' : '' }} value="pending">Pendiente</option>
                                <option {{ old('status') == 'processing' ? 'selected="selected"' : '' }} value="processing">Pendiente</option>
                                <option {{ old('status') == 'completed' ? 'selected="selected"' : '' }} value="completed">Completado</option>
                                <option {{ old('status') == 'declined' ? 'selected="selected"' : '' }} value="declined">Declinado</option>
                                <option {{ old('status') == 'cancelled' ? 'selected="selected"' : '' }} value="cancelled">Cancelado</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_id">Identificador del usuario </label>
                        <input type="number" class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" min="0"  value="{{ old('user_id',0) }}">
                        @error('user_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <h5 class="my-3">Items de la Orden</h5>
                    <div class="col-12">
                        <span class="invalid-feedback" id="ErrorTable"></span>
                        <table class="table table-striped table-hover table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Tamaño de Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th class="no-sort">Acciones</th>
                                </tr>
                                <tr>
                                    <th>
                                        <select class="form-control @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
                                            @foreach ($products as $product)
                                                <option {{ old('product_id') == $product->id  ? 'selected="selected"' : '' }} value={{ $product->id }}>{{ $product->id .': ' . $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <th>
                                        <select class="form-control @error('product_size_id') is-invalid @enderror" id="product_size_id" name="product_size_id">
                                        </select>
                                    </th>
                                    <th>
                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" min="0" value="{{ old('quantity',0) }}">
                                    </th>
                                    <th>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" min="0" step="any" disabled>
                                    </th>
                                    <th><Button id="addOption" class="btn btn-primary">Agregar Opción</Button></th>
                                </tr>
                            </thead>
                            <tbody id="orderItems">
                                <tr class="total-row">
                                    <td class="col-4">Total importe Sin Descuento</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="col-2" id="totalGrossImport">0</td>
                                </tr>
                                <tr class="total-row">
                                    <td class="col-4">Descuento aplicado</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="col-2" id="totalDiscountApplied">0</td>
                                </tr>
                                <tr class="total-row">
                                    <td class="col-4">Importe Total</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="col-2" id="totalNetImport">0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-start my-4">
                      <button type="submit" class="btn btn-primary w-auto">Crear Orden</button>
                    </div>
                </form>
                <div class="d-flex flex-row-reverse mt-3">
                    <a href="/orders" class="btn btn-secondary">Volver a la lista de Ordenes</a>
                </div>
            </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    // When the document is ready
    $(document).ready(function () {

        // Pass the products and product sizes to JavaScript variables
        const products = @json($products);
        const productSizes = @json($productsizes);
        const discountcodes = @json($discountcodes);
        // Initialize the product sizes based on the selected product
        updateProductSizes();

        // When the product selection changes, update the product sizes accordingly
        $('#product_id').on('change', function () {
            updateProductSizes();
        });

        //when the product size selection changes, update the product price accordingly
        $('#product_size_id').on('change', function () {
            updateProductPrice();
        });

        // When the "Agregar Opción" button is clicked
        $('#addOption').on('click', function (event) {
            event.preventDefault();
            // Get the selected values
            const productId = $('#product_id').val();
            const productSizeId = $('#product_size_id').val();
            const quantity = $('#quantity').val();
            const price = $('#price').val();

            if(quantity == 0){
                $('#ErrorTable').text('La cantidad no puede ser 0');
                // Show the error message div
                $('#ErrorTable').show();
                return;
            }
            // Create a new table row with the selected values
            const newRow = `<tr>
                                <td>${productId}</td>
                                <td>${productSizeId}</td>
                                <td>${quantity}</td>
                                <td>${price}</td>
                                <td><button class="btn btn-danger btn-sm delete-option">Eliminar</button></td>
                            </tr>`;
            // Get the reference to the last three rows in the table body
            const lastThreeRows = $('#dataTable tbody tr:last-child').prevAll().slice(0, 3);

            // Insert the new row above the last three rows
            lastThreeRows.last().before(newRow);
            calculateTotals();
        });

        // Function to update product sizes based on the selected product
        function updateProductSizes() {

            const selectedProductId = $('#product_id').val();
            $('#product_size_id').empty();

            // Filter and add only the product sizes that belong to the selected product
            productSizes.forEach(function(productSize) {
                if (productSize.product_id == selectedProductId) {
                    $('#product_size_id').append(`<option value="${productSize.id}">${productSize.id}: ${productSize.name}</option>`);
                }
            });

            updateProductPrice();
        }

        function updateProductPrice(){
            const productsizesOptions = productSizes.filter(productsize => productsize.product_id == $('#product_id').val());
            if(productsizesOptions.length <= 0){
                const product = products.find(product => product.id == $('#product_id').val());
                $('#price').val(product.price);
                return;
            }

            const selectedProductSizeId = $('#product_size_id').val();
            const price = getProductSizePrice(selectedProductSizeId);
            $('#price').val(price);
        }


        // Function to get the price based on the selected product size ID
        function getProductSizePrice(productSizeId) {
            const productSize = productSizes.find(function (productSize) {
                return productSize.id == productSizeId;
            });

            return productSize ? productSize.price : 0;
        }

        // Function to calculate and update the totals
        function calculateTotals() {
            console.log('Calculating totals...');
            let totalGrossImport = 0;
            let totalDiscountApplied = 0;
            let totalNetImport = 0;

            // Get the reference to the table body
            const tableBody = $('#dataTable tbody');

            // Loop through each row in the table body
            tableBody.find('tr').each(function () {
                if (!$(this).hasClass('total-row')) { // Exclude rows with class 'total-row'
                    const quantity = parseFloat($(this).find('td:eq(2)').text());
                    const price = parseFloat($(this).find('td:eq(3)').text());

                    // Calculate the row's gross import and update the total gross import
                    const grossImport = quantity * price;
                    totalGrossImport += grossImport;

                    // ... Add any other calculations based on the table rows (e.g., discounts) ...
                }
            });

            //Apply discount over the gross import
            if(discountcodes.length > 0){
                for(let i = 0; i < discountcodes.length; i++){
                    if(discountcodes[i].id == $('#discount_code_id').val()){
                        totalDiscountApplied = totalGrossImport * discountcodes[i].discount;
                        break;
                    }
                }
            }

            // Update the net import (exclude the last 3 rows from the calculation)
            totalNetImport = totalGrossImport - totalDiscountApplied;

            // Update the corresponding row in the table body with the totals
            $('#totalGrossImport').text(totalGrossImport.toFixed(2));
            $('#totalDiscountApplied').text(totalDiscountApplied.toFixed(2));
            $('#totalNetImport').text(totalNetImport.toFixed(2));
        }



        // When the delete button in the table is clicked
        $(document).on('click', '.delete-option', function (event) {
            event.preventDefault();
            // Remove the entire row from the table
            $(this).closest('tr').remove();
            calculateTotals();
        });
    });
</script>
@endsection


