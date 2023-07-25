<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Retrieve only verified users with pagination
        $categoriesQuery = Category::query();

        // Check if the name search parameter is provided
        $name = $request->query('name');
        if ($name) {
            // Apply the name filter to the query
            $categoriesQuery->where('name', 'like', '%' . $name . '%');
        }

        // Paginate the categories
        $categories = $categoriesQuery->paginate(10);

        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $categories->lastPage())) {
            return redirect()->route('categories.index');
        }

        $searchParam = $name ? $name : '';

        // Return a view or JSON response as desired
        return view('categories.index', compact('categories', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Show the form for creating a new category
        return view('categories.create');
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
            'section' => 'required',
        ]);

        // Create a new user with the specified role
        $category = Category::create([
            'name' => $validatedData['name'],
            'section' => $validatedData['section'],
        ]);
        // Return a success response or redirect as desired
        return redirect()->route('categories.index')->with('success', 'Categoria creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        // Show the form for editing the specified Category
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'section' => 'required',
        ]);

        // Update user with the specified role
        $category->name = $validatedData['name'];
        $category->section = $validatedData['section'];
        $category->save();

        // Return a success response or redirect as desired
        return redirect()->route('categories.index')->with('success', 'Categoria actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // Delete the specified Category
        $category->delete();

        // Return a success response or redirect as desired
        return redirect()->route('categories.index')->with('success', 'Categoria borrado exitosamente.');
    }
}
