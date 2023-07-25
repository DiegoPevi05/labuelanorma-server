<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\DiscountCode;
use App\Models\User;
use App\Models\Order_item;
use App\Models\Product;
use App\Models\Product_size;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ordersQuery = Order::query();

        // Check if the name search parameter is provided
        $order_number = $request->query('order_number');
        if ($order_number) {
            // Apply the name filter to the query
            $ordersQuery->where('order_number', 'like', '%' . $order_number . '%');
        }

        // Paginate the products
        $orders = $ordersQuery->paginate(10);


        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $orders->lastPage())) {
            return redirect()->route('orders.index');
        }

        // Get the IDs of the fetched orders
        $orderIds = $orders->pluck('id');

        // Get the related order_items for the fetched orders
        $orderItems = Order_item::whereIn('order_id', $orderIds)->get();

        $searchParam = $order_number ? $order_number : '';

        // Return a view or JSON response as desired
        return view('orders.index', compact('orders','orderItems', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $discountcodes = DiscountCode::all();
        $products = Product::all();
        $productsizes = Product_size::all();
        return view('orders.create', compact('discountcodes', 'products', 'productsizes'));
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
            'gross_import' => 'required',
            'status' => 'required',
            'user_id' => 'required|exists:users,id',
            'calculated_amount' => 'required',
            'discount_code_id' => [
                    'nullable',
                    function ($attribute, $value, $fail) {
                        // Check if the category with the given ID exists in the categories table
                        if($value != null){
                            $discountcode = DiscountCode::find($value);

                            if (!$discountcode) {
                                $fail("Codigo de Descuento no valido.");
                            }
                        }
                    },
            ]
        ]);

        // Create a new product with the specified data
        $orderData =[
            'user_id' => $validatedData['user_id'],
            'status' => $validatedData['status'],
            'discount_code_id' => $validatedData['discount_code_id'],
            'calculated_amount' => $validatedData['calculated_amount'],
        ];

        // FORMAT ID OF THE ORDER
        // Retrieve the last created order from the database
        $lastOrder = Order::orderBy('created_at', 'desc')->first();
        // Extract the numeric part of the last order number
        $lastOrderNumber = $lastOrder ? intval(substr($lastOrder->order_number, 4)) : 0;
        // Increment the numeric part by one to get the next order number
        $newOrderNumber = $lastOrderNumber + 1;
        // Format the new order number with leading zeros (6 digits long)
        $formattedOrderNumber = str_pad($newOrderNumber, 6, '0', STR_PAD_LEFT);
        // Set the new order number in the $orderData array
        $orderData['order_number'] = 'ORD-' . strtoupper($formattedOrderNumber);


        //SET GROSS IMPORT
        // Set the calculated gross_import if 'calculated_amount' is true
        if ($request->has('calculated_amount') && $request->input('calculated_amount')) {
            $orderItemsData = $request->input('order_items');

            if (is_array($orderItemsData)) {
                $grossImport = 0;

                foreach ($orderItemsData as $orderItemData) {
                    // Ensure the required data is present
                    if (
                        isset($orderItemData['quantity']) &&
                        isset($orderItemData['price']) &&
                        is_numeric($orderItemData['quantity']) &&
                        is_numeric($orderItemData['price'])
                    ) {
                        $grossImport += $orderItemData['quantity'] * $orderItemData['price'];
                    }
                }

                $orderData['gross_import'] = $grossImport;
            }
        } else {
            // Use the provided 'gross_import' value from the request
            $orderData['gross_import'] = $validatedData['gross_import'] ? $validatedData['gross_import'] : 0;
        };

        //APPLY DISCOUNT TO GROSS IMPORT

        if($validatedData['gross_import'] > 0 && $validatedData['discount_code_id']){
            // Retrieve the discount code from the database
            $discountCode = DiscountCode::find($validatedData['discount_code_id']);
            // Calculate the discount amount
            $discountAmount = $validatedData['gross_amount'] * ($discountCode->discount / 100);

            // Calculate the net amount
            $netAmount = $validatedData['gross_amount'] - $discountAmount;

            // Set the discount amount and net amount in the $orderData array
            $orderData['discount_amount'] = $discountAmount;

            $orderData['net_amount'] = $netAmount;
        }else{
            $orderData['discount_amount'] = 0;
            $orderData['net_amount'] = $validatedData['gross_amount'];
        }

        // Create the order and associate order items if they exist in the request
        DB::transaction(function () use ($orderData, $request) {
            // Create the order
            $order = Order::create($orderData);

            // Check if order_items exist in the request
            if ($request->has('order_items')) {
                $orderItemsData = $request->validate([
                    'order_items' => 'required|array',
                    'order_items.*.product_id' => 'required|exists:products,id',
                    'order_items.*.product_size_id' => 'nullable|exists:product_sizes,id',
                    'order_items.*.quantity' => 'required|integer|min:1',
                    'order_items.*.price' => 'required|numeric|min:0',
                ]);

                // Create and associate order items with the order
                foreach ($orderItemsData['order_items'] as $orderItemData) {
                    $orderItem = new Order_item([
                        'product_id' => $orderItemData['product_id'],
                        'product_size_id' => $orderItemData['product_size_id'],
                        'quantity' => $orderItemData['quantity'],
                        'price' => $orderItemData['price'],
                    ]);

                    $order->order_items()->save($orderItem);
                }
            }
        });
        
        // Return a success response or redirect as desired
        return redirect()->route('orders.index')->with('success', 'Orden creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $discountcodes = DiscountCode::all();
        return view('orders.edit', compact('order', 'discountcodes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {

        return redirect()->route('orders.index')->with('success', 'La Orden se ha actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        // Delete the specified Category
        $order->delete();
        // Return a success response or redirect as desired
        return redirect()->route('orders.index')->with('success', 'La Orden se ha borrado exitosamente.');
    }
}
