<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $partnersQuery = Partner::query();

        // Check if the name search parameter is provided
        $name = $request->query('name');
        if ($name) {
            // Apply the name filter to the query
            $partnersQuery->where('name', 'like', '%' . $name . '%');
        }

        // Paginate the products
        $partners = $partnersQuery->paginate(10);


        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $partners->lastPage())) {
            return redirect()->route('partners.index');
        }

        $searchParam = $name ? $name : '';

        // Return a view or JSON response as desired
        return view('partners.index', compact('partners', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('partners.create');
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
            'link_content' => 'required',
            'brand_link' => 'required',
            'tags' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,webp',
        ]);

        $destinationPath = public_path() . '/images/partners';
        $imageFileName = null;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $extension = $file->extension();
            $fileName = 'partner_' . time() . '.' . $extension;
            $file->move($destinationPath, $fileName);
            $imageFileName = $fileName;
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


        // Create a new giveaway with the specified data
        $PartnerData = [
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'link_content' => $validatedData['link_content'],
            'brand_link' => $validatedData['brand_link'],
            'tags' => json_encode($tags),
            'image_brand' => '/images/partners/' . $imageFileName,
        ];

        // Create a new product with the specified data
        $partner = Partner::create($PartnerData);

        // Return a success response or redirect as desired
        return redirect()->route('partners.index')->with('success', 'Partner creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        return view('partners.show', compact('partner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        return view('partners.edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'link_content' => 'required',
            'brand_link' => 'required',
            'tags' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,webp',
        ]);

        $destinationPath = public_path() . '/images/partners';
        $imageOldFilename = $partner->image_brand;
        $imageFileName = null;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $extension = $file->extension();
            $fileName = 'partner_' . time() . '.' . $extension;
            $file->move($destinationPath, $fileName);
            $imageFileName = $fileName;

            if ($imageOldFilename !== null) {
                $oldImagePath = public_path($imageOldFilename);
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }else{
            $imageFileName = basename($partner->image_brand);
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

        // update giveaway with the specified data
        $PartnerData = [
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'link_content' => $validatedData['link_content'],
            'brand_link' => $validatedData['brand_link'],
            'tags' => json_encode($tags),
            'image_brand' => '/images/partners/' . $imageFileName,
        ];

        // Create a new product with the specified data
        $partner->update($PartnerData);

        // Return a success response or redirect as desired
        return redirect()->route('partners.index')->with('success', 'Partner actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        // Store old image URLs in a separate array
        $imagePartner = $partner->image_brand;

        if ($imagePartner !== null) {
            $ImagePath = public_path($imagePartner);
            if (file_exists($ImagePath) && is_file($ImagePath)) {
                unlink($ImagePath);
            }
        }

        // Delete the specified Category
        $partner->delete();
        // Return a success response or redirect as desired
        return redirect()->route('partners.index')->with('success', 'Partner borrado exitosamente.');
    }
}
