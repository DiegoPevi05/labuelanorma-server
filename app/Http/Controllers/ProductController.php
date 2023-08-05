<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_size;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productsQuery = Product::query();

        // Check if the name search parameter is provided
        $name = $request->query('name');
        if ($name) {
            // Apply the name filter to the query
            $productsQuery->where('name', 'like', '%' . $name . '%');
        }

        // Paginate the products
        $products = $productsQuery->paginate(10);


        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $products->lastPage())) {
            return redirect()->route('products.index');
        }

        $searchParam = $name ? $name : '';

        // Return a view or JSON response as desired
        return view('products.index', compact('products', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        // Show the form for editing the specified Product
        $categories = Category::all();
        return view('products.create',compact('categories'));
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
            'name' => 'required',
            'description' => 'required',
            'details' => 'required',
            'price' => 'required',
            'tags' => 'nullable',
            'label' => 'nullable',
            'is_new' => 'nullable',
            'is_unity'=> 'nullable',
            'stock'=>'nullable',
            'category_id' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        // Check if the category with the given ID exists in the categories table
                        $category = Category::find($value);

                        if (!$category) {
                            $fail("The selected category is invalid.");
                        }
                    },
                ],
            'image_1' => 'required|image|mimes:jpeg,png,webp',
            'image_2' => 'nullable|image|mimes:jpeg,png,webp',
            'image_3' => 'nullable|image|mimes:jpeg,png,webp',
            'image_4' => 'nullable|image|mimes:jpeg,png,webp',
        ]);

        $destinationPath = public_path() . '/images/products';
        $imageFileNames = [];



        // Process images (image_1, image_2, image_3, and image_4)
        for ($i = 1; $i <= 4; $i++) {
            $fieldName = 'image_' . $i;
            if ($request->hasFile($fieldName) && $request->file($fieldName)->isValid()) {
                $file = $request->file($fieldName);
                $extension = $file->extension();
                $fileName = 'products_' . time() . '_'.$i.'.' . $extension;
                $file->move($destinationPath, $fileName);
                $imageFileNames[] = $fileName;
            }
        }

        $tags = [];
        // validate if the field is not empty and is a string
        if (!empty($request->tags) && is_string($request->tags)) {

            $tags_raw = explode('|', $request->tags);

            foreach ($tags_raw as $tag) {
                $tag = trim($tag);
                if (!empty($tag) && is_string($tag)) {
                    $tags[] = $tag;
                }
            }
        }

        // Convert 'is_new' to a boolean value (true/false)
        $is_new = isset($validatedData['is_new']) && $validatedData['is_new'] ? true : false;

        // Convert 'is_unity' to a boolean value
        $is_unity = isset($validatedData['is_unity']) && $validatedData['is_unity'] ? true : false;

        // Create a new product with the specified data
        $productData = [
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'details' => $validatedData['details'],
            'price' => $validatedData['price'] ? $validatedData['price'] : 0,
            'category_id' => $validatedData['category_id'],
            'label' => $validatedData['label'],
            'tags' => json_encode($tags),
            'is_new' => $is_new,
            'is_unity' => $is_unity,
            'stock' => $is_unity ? $validatedData['stock'] : 0,
        ];

        // Assign image URLs to the product data
        for ($i = 1; $i <= 4; $i++) {
            $fieldName = 'image_url_' . $i;
            $productData[$fieldName] = isset($imageFileNames[$i - 1]) ? '/images/products/' . $imageFileNames[$i - 1] : null;
        }



        // Create a new product with the specified data
        $product = Product::create($productData);

        // Create a new product size if the product stock is per unity
        if($is_unity){
            $product_size = Product_size::create([
                'type' => 'Unidad',
                'name' => 'UND',
                'stock' => $validatedData['stock'],
                'price' => $validatedData['price'],
                'product_id' => $product->id,
            ]);
        }
        // Return a success response or redirect as desired
        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // Show the form for editing the specified Category
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'details' => 'required',
            'price' => 'required',
            'tags' => 'nullable',
            'label' => 'nullable',
            'is_new' => 'nullable',
            'is_unity'=> 'nullable',
            'stock'=>'nullable',
            'category_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Check if the category with the given ID exists in the categories table
                    $category = Category::find($value);

                    if (!$category) {
                        $fail("The selected category is invalid.");
                    }
                },
            ],
            'image_1' => 'nullable|image|mimes:jpeg,png,webp',
            'image_2' => 'nullable|image|mimes:jpeg,png,webp',
            'image_3' => 'nullable|image|mimes:jpeg,png,webp',
            'image_4' => 'nullable|image|mimes:jpeg,png,webp',
        ]);

        $destinationPath = public_path() . '/images/products';
        $imageFileNames = [];

        // Store old image URLs in a separate array
        $oldImageUrls = [
            $product->image_url_1,
            $product->image_url_2,
            $product->image_url_3,
            $product->image_url_4,
        ];

        // Process images (image_1, image_2, image_3, and image_4)
        for ($i = 1; $i <= 4; $i++) {
            $fieldName = 'image_' . $i;

            if ($request->hasFile($fieldName) && $request->file($fieldName)->isValid()) {
                $file = $request->file($fieldName);
                $extension = $file->extension();
                $fileName = 'products_' . time() . '_'.$i.'.' . $extension;
                $file->move($destinationPath, $fileName);
                $imageFileNames[] = $fileName;

                // Delete old image if new image provided
                if (isset($oldImageUrls[$i - 1]) && $oldImageUrls[$i - 1] !== null) {
                    $oldImagePath = public_path($oldImageUrls[$i - 1]);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            } else {
                // If no new image provided, keep the old image URL
                $imageFileNames[] = basename($oldImageUrls[$i - 1]);
            }
        }


        $tags = [];
        // validate if the field is not empty and is a string
        if (!empty($request->tags) && is_string($request->tags)) {

            $tags_raw = explode('|', $request->tags);

            foreach ($tags_raw as $tag) {
                $tag = trim($tag);
                if (!empty($tag) && is_string($tag)) {
                    $tags[] = $tag;
                }
            }
        }

        // Convert 'is_new' to a boolean value (true/false)
        $is_new = isset($validatedData['is_new']) && $validatedData['is_new'] ? true : false;


        // Convert 'is_unity' to a boolean value
        $is_unity = isset($validatedData['is_unity']) && $validatedData['is_unity'] ? true : false;

        // Update the product with the specified data
        $product->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'details' => $validatedData['details'],
            'price' => $validatedData['price'] ? $validatedData['price'] : 0,
            'category_id' => $validatedData['category_id'],
            'tags' => json_encode($tags),
            'label' => $validatedData['label'],
            'is_new' => $is_new,
            'is_unity' => $is_unity,
            'stock' => $is_unity ? $validatedData['stock'] : 0,
            'image_url_1' => '/images/products/' . $imageFileNames[0],
            'image_url_2' => isset($imageFileNames[1]) ? '/images/products/' . $imageFileNames[1] : null,
            'image_url_3' => isset($imageFileNames[2]) ? '/images/products/' . $imageFileNames[2] : null,
            'image_url_4' => isset($imageFileNames[3]) ? '/images/products/' . $imageFileNames[3] : null,
        ]);

        // Create a new product size if the product stock is per unity
        if($is_unity){
            Product_size::where('id', $product->id)->delete();
            $product_size = Product_size::create([
                'type' => 'Unidad',
                'name' => 'UND',
                'stock' => $validatedData['stock'],
                'price' => $validatedData['price'],
                'product_id' => $product->id,
            ]);
        }

        // Return a success response or redirect as desired
        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

        // Store old image URLs in a separate array
        $ImagesProduct = [
            $product->image_url_1,
            $product->image_url_2,
            $product->image_url_3,
            $product->image_url_4,
        ];

        for ($i = 1; $i <= 4; $i++) {
            if (isset($ImagesProduct[$i - 1]) && $ImagesProduct[$i - 1] !== null) {
                $ImagePath = public_path($ImagesProduct[$i - 1]);
                if (file_exists($ImagePath)) {
                    unlink($ImagePath);
                }
            }
        }

        // Delete the specified Category
        $product->delete();
        // Return a success response or redirect as desired
        return redirect()->route('products.index')->with('success', 'Producto borrado exitosamente.');
    }
}
