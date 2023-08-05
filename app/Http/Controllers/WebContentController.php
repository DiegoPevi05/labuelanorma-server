<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebContent;

class WebContentController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $webcontentQuery = WebContent::query();

        // Check if the name search parameter is provided
        $section = $request->query('section');
        if ($section) {
            // Apply the name filter to the query
            $webcontentQuery->where('section', 'like', '%' . $section . '%');
        }

        // Paginate the products
        $webcontents = $webcontentQuery->paginate(10);


        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $webcontents->lastPage())) {
            return redirect()->route('webcontents.index');
        }

        $searchParam = $section ? $section : '';

        // Return a view or JSON response as desired
        return view('webcontents.index', compact('webcontents', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('webcontents.create');
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
            'section' => 'required',
            'sub_section' => 'required',
            'content_type' => 'required',
            'content' => 'required',
        ]);


        $webContentData = [];

        $webContentData['section'] = $validatedData['section'];
        $webContentData['sub_section'] = $validatedData['sub_section'];
        $webContentData['content_type'] = $validatedData['content_type'];

        if($validatedData['content_type'] == 'image'){
            $destinationPath = public_path() . '/images/web';
            $imageFileName = null;

            if ($request->hasFile('content') && $request->file('content')->isValid()) {
                $file = $request->file('content');
                $extension = $file->extension();
                $fileName = 'web_' . time() . '.' . $extension;
                $file->move($destinationPath, $fileName);
                $imageFileName = $fileName;
                $webContentData['content'] =  '/images/web/' . $imageFileName;
            }
        }else{

            $webContentData['content'] = $validatedData['content'];
        }

        $webcontent = WebContent::create($webContentData);

        // Return a success response or redirect as desired
        return redirect()->route('webcontents.index')->with('success', 'Contenido Web creado exitosamente.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(WebContent $webcontent)
    {
        return view('webcontents.show', compact('webcontent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(WebContent $webcontent)
    {
        return view('webcontents.edit', compact('webcontent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WebContent $webcontent )
    {
        $validatedData = $request->validate([
            'section' => 'required',
            'sub_section' => 'required',
            'content_type' => 'required',
            'content' => 'nullable',
        ]);



        $webContentData = [];

        $webContentData['section'] = $validatedData['section'];
        $webContentData['sub_section'] = $validatedData['sub_section'];
        $webContentData['content_type'] = $validatedData['content_type'];

        if($validatedData['content_type'] == 'image'){
            $destinationPath = public_path() . '/images/web';
            $imageFileName = null;
            $oldImageName = $webcontent->content;

            if ($request->hasFile('content') && $request->file('content')->isValid()) {
                $file = $request->file('content');
                $extension = $file->extension();
                $fileName = 'web_' . time() . '.' . $extension;
                $file->move($destinationPath, $fileName);
                $imageFileName = $fileName;

                if($oldImageName !== null){
                    $oldImagePath = public_path($oldImageName);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            }else{
                $imageFileName = basename($oldImageName);
            }

            $webContentData['content'] =  '/images/web/' . $imageFileName;
        }else{

            $webContentData['content'] = $validatedData['content'];
        }

        $webcontent->update($webContentData);

        // Return a success response or redirect as desired
        return redirect()->route('webcontents.index')->with('success', 'Contenido Web creado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(WebContent $webcontent)
    {
        // delete image realated
        if($webcontent->content_type === 'image'){
            $imageWebcontent = $webcontent->content;

            if ($imageWebcontent !== null) {
                $ImagePath = public_path($imageWebcontent);
                if (file_exists($ImagePath)) {
                    unlink($ImagePath);
                }
            }
        }
        // Delete the specified Category
        $webcontent->delete();
        // Return a success response or redirect as desired
        return redirect()->route('webcontents.index')->with('success', 'Contenido Web exitosamente.');
    }
}
