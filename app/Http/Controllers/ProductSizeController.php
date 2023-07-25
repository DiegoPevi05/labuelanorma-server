<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Product_size;


class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productsizesQuery = Product_size::query();

        // Check if the name search parameter is provided
        $product_id = $request->query('productid');
        if ($product_id) {
            // Apply the name filter to the query
            $productsizesQuery->where('product_id', '=', $product_id);
        }

        // Paginate the products
        $productsizes = $productsizesQuery->paginate(10);


        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $productsizes->lastPage())) {
            return redirect()->route('productsizes.index');
        }

        $searchParam = $product_id ? $product_id : '';

        // Return a view or JSON response as desired
        return view('productsizes.index', compact('productsizes', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Show the form for editing the specified Product
        $products = Product::all();
        return view('productsizes.create',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'type' => 'required',
            'name' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'product_id' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        // Check if the category with the given ID exists in the categories table
                        $product = Product::find($value);

                        if (!$product) {
                            $fail("The selected Product is invalid.");
                        }
                    },
            ]
        ]);


        // Create a new product with the specified data
        $producesize = Product_size::create([
            'type' => $validatedData['type'],
            'name' => $validatedData['name'],
            'stock' => $validatedData['stock'],
            'price' => $validatedData['price'],
            'product_id' => $validatedData['product_id']
        ]);

        // Return a success response or redirect as desired
        return redirect()->route('productsizes.index')->with('success', 'Talla de Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product_size $productsize)
    {
        return view('productsizes.show', compact('productsize'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product_size $productsize)
    {
        // Show the form for editing the specified Product Size
        $products = Product::all();
        return view('productsizes.edit', compact('productsize', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product_size $productsize)
    {
        $validatedData = $request->validate([
            'type' => 'required',
            'name' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'product_id' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        // Check if the category with the given ID exists in the categories table
                        $product = Product::find($value);

                        if (!$product) {
                            $fail("The selected Product is invalid.");
                        }
                    },
            ]
        ]);

        $productsize->update([
            'type' => $validatedData['type'],
            'name' => $validatedData['name'],
            'stock' => $validatedData['stock'],
            'price' => $validatedData['price'],
            'product_id' => $validatedData['product_id'],
        ]);

        // Return a success response or redirect as desired
        return redirect()->route('productsizes.index')->with('success', 'Talla de Producto Actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product_size $productsize)
    {
        // Delete the specified Category
        $productsize->delete();
        // Return a success response or redirect as desired
        return redirect()->route('productsizes.index')->with('success', 'Talla de Producto borrado exitosamente.');
    }
}
