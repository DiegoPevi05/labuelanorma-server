<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebContent;
use App\Models\Giveaway;
use App\Models\Product;
use App\Models\Product_size;
use App\Models\Category;
use App\Models\DiscountCode;

class WebPublicController extends Controller
{
    
    public function GetWebData()
    {
        $web = WebContent::all();
        $giveaway = Giveaway::orderBy('created_at', 'desc')->first();
        $products = Product::orderBy('created_at', 'desc')->take(3)->get();
        $categories = Category::all();
        return response()->json([
            'web' => $web,
            'giveaway' => $giveaway,
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function GetProductsByCategory($category_id, $page = 1)
    {
        if ($category_id == 0)
        {
            $products = Product::orderBy('created_at', 'desc')->paginate(10, ['*'], 'page', $page);
        }
        else
        {
            $products = Product::where('category_id', $category_id)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'page', $page);
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

        $discount = Discount::where('code', $code)->first();

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
}
