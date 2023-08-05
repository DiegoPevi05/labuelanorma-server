<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebContent;
use App\Models\Giveaway;
use App\Models\Product;
use App\Models\Product_size;
use App\Models\Category;
use App\Models\DiscountCode;
use App\Models\Partner;
use App\Models\Giveaway_participants;

class WebPublicController extends Controller
{

    public function GetWebData()
    {
        $web = WebContent::all();
        $giveaway = Giveaway::orderBy('created_at', 'desc')->first();
        $products = Product::orderBy('created_at', 'desc')->orderBy('is_new', 'desc')->take(3)->get();
        $partners = Partner::OrderBy('created_at','desc')->take(5)->get();
        return response()->json([
            'web' => $web,
            'giveaway' => $giveaway,
            'products' => $products,
            'partners' => $partners
        ]);
    }

    public function GetProductsByFilter(Request $request)
    {
        $page = $request->query('page',1);
        $section = $request->query('section','All');
        $category = $request->query('category','All');
        $featured = $request->query('order','All');
        $order = $request->query('order','All');

        $productsQuery = Product::query();
        $products = [];

        if($section != 'All' || $category != 'All'){
            $categoryObjects = null;

            if($section != 'All' and $category == 'All'){
                $categoryObjects = Category::where('section', $section)->pluck('id');;
            }else if($section == 'All' and $category != 'All'){
                $categoryObjects = Category::where('name', $category)->pluck('id');;
            }else{
                $categoryObjects = Category::where('section', $section)->where('name', $category)->pluck('id');;
            }

            if ($categoryObjects && $categoryObjects->count() > 0) {
                $productsQuery->whereIn('category_id', $categoryObjects);
            }

        }

        if($featured != 'All'){
            $productsQuery->where('label',$featured);
        }

        if($order != 'All'){
            if($order = 'Lo Nuevo'){
                $productsQuery->orderBy('created_at', 'desc');
            }else if($order = 'Precio: Menor a Mayor'){
                $productsQuery->orderBy('price', 'asc');
            }else if($order = 'Precio: Mayor a Menor'){
                $productsQuery->orderBy('price', 'desc');
            }
        }

        if ($page >= 1) {
            // Apply the name filter to the query
            $products = $productsQuery->paginate(10, ['*'], 'page', $page);
        }else{
            $products = $productsQuery->paginate(10, ['*'], 'page', 1);
        }

        // Loop through the products and add the properties
        foreach ($products as $product) {
            // Assuming your Product model has a "category" relationship defined
            $category = Category::where('id', $product->category_id)->first();

            $product->section = $category->section;
            $product->category = $category->name;

            $sizes = Product_size::where('product_id', $product->id)->get();
            $sizesFilter = [];

            foreach ($sizes as $size) {
                $sizeUnit = new \stdClass(); // Create a new stdClass object (similar to an empty anonymous object)
                $sizeUnit->name = $size->name;
                $sizeUnit->inStock = $size->stock > 0 ? true : false;

                $sizesFilter[] = $sizeUnit; // Add the $sizeUnit object to the $sizesFilter array
            }

            if($sizes->count() > 0){
                $product->sizes = $sizesFilter;
            }else {
                $product->sizes = [];
            }
        }

        return response()->json([
            'products' => $products,
        ]);
    }

    public function GetCategories(){
        $categories = Category::all();
        return response()->json([
            'categories' => $categories,
        ]);

    }

    public function ValidateDiscountCode(Request $request){

        $code = $request->input('code');

        $discount = DiscountCode::where('code', $code)->first();

        if($discount){
            if($discount->quantity_discounts <= 0){
                return response()->json(['error' => 'No hay más codigos de descuento'], 404);
            }

            if($discount->expired_date < now()){
                return response()->json(['error' => 'Codigo de descuento expirado'], 404);
            }

            if($discount->status == 'inactive'){
                return response()->json(['error' => 'Codigo de descuento no valido'], 404);
            }

            return response()->json(['message' => 'Codigo de descuento valido'], 200);
        }
        else{
            return response()->json(['error' => 'Codigo de descuento no valido'], 404);
        }
    }

    public function GetGiveaways(Request $request)
    {
        $page = $request->query('page', 1); // Extract the 'page' query parameter, default to 1 if not provided

        $giveaways = Giveaway::orderBy('created_at', 'desc')->paginate(5, ['*'], 'page', $page);

        return response()->json([
            'giveaways' => $giveaways,
        ]);
    }

    public function GetGiveawaysAuthorized(Request $request){
        $page = $request->query('page', 1); // Extract the 'page' query parameter, default to 1 if not provided

        $user = $request->user;

        $giveaways = Giveaway::orderBy('created_at', 'desc')->paginate(5, ['*'], 'page', $page);

        // Loop through each giveaway
        foreach ($giveaways as $giveaway) {

            $alreadyIn = Giveaway_participants::where('giveaway_id', $giveaway->id)->where('user_id', $user->id)->exists();
            // Add the alreadyIn property to the giveaway
            $giveaway->alreadyIn = $alreadyIn;
        }

        return response()->json([
            'giveaways' => $giveaways,
        ]);

    }
}
