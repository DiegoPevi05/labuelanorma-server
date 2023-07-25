<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiscountCode;

class DiscountCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $discountcodesQuery = DiscountCode::query();

        // Check if the name search parameter is provided
        $name = $request->query('name');
        if ($name) {
            // Apply the name filter to the query
            $discountcodesQuery->where('name', 'like', '%' . $name . '%');
        }

        // Paginate the products
        $discountcodes = $discountcodesQuery->paginate(10);


        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $discountcodes->lastPage())) {
            return redirect()->route('discountcodes.index');
        }

        $searchParam = $name ? $name : '';

        // Return a view or JSON response as desired
        return view('discountcodes.index', compact('discountcodes', 'searchParam'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('discountcodes.create');
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
            'discount' => 'required',
            'quantity_discounts' => 'required',
            'status' => 'required',
            'expired_date' => 'required',
        ]);

        // Create a new discount code with the specified data
        $discountcode = DiscountCode::create([
            'name' => $validatedData['name'],
            'discount' => $validatedData['discount'],
            'quantity_discounts' => $validatedData['quantity_discounts'],
            'status' => $validatedData['status'],
            'expired_date' => $validatedData['expired_date']
        ]);

        // Return a success response or redirect as desired
        return redirect()->route('discountcodes.index')->with('success', 'Codigo de Descuento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DiscountCode $discountcode)
    {
        return view('discountcodes.show', compact('discountcode'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DiscountCode $discountcode)
    {
        return view('discountcodes.edit', compact('discountcode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DiscountCode $discountcode)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'discount' => 'required',
            'quantity_discounts' => 'required',
            'status' => 'required',
            'expired_date' => 'required',
        ]);

        $discountcode->update([
            'name' => $validatedData['name'],
            'discount' => $validatedData['discount'],
            'quantity_discounts' => $validatedData['quantity_discounts'],
            'status' => $validatedData['status'],
            'expired_date' => $validatedData['expired_date'],
        ]);

        // Return a success response or redirect as desired
        return redirect()->route('discountcodes.index')->with('success', 'Codigo de Descuento Actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiscountCode $discountcode)
    {
        // Delete the specified Category
        $discountcode->delete();
        // Return a success response or redirect as desired
        return redirect()->route('discountcodes.index')->with('success', 'Codigo de Descuento borrado exitosamente.');
    }
}
