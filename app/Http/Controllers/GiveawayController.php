<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Giveaway;
use App\Models\User;
use App\Models\Giveaway_participants;

class GiveawayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $giveawaysQuery = Giveaway::query();

        // Check if the name search parameter is provided
        $name = $request->query('name');
        if ($name) {
            // Apply the name filter to the query
            $giveawaysQuery->where('name', 'like', '%' . $name . '%');
        }

        // Paginate the products
        $giveaways = $giveawaysQuery->paginate(10);


        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $giveaways->lastPage())) {
            return redirect()->route('giveaways.index');
        }

        $searchParam = $name ? $name : '';

        // Return a view or JSON response as desired
        return view('giveaways.index', compact('giveaways', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('giveaways.create');
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
            'start_date' => 'required',
            'end_date' => 'required',
            'user_winner_id' => [
                'nullable', // Require the value to be present and not empty
                function ($attribute, $value, $fail) {
                    if ($value !== null && $value !== '0') {
                        // Check if the user with the given ID exists in the users table
                        $user = User::find($value);

                        if (!$user) {
                            $fail("El usuario no es valido.");
                        }
                    }
                },
            ],
            'image_1' => 'required|image|mimes:jpeg,png,webp',
        ]);

        $destinationPath = public_path() . '/images/giveaways';
        $imageFileName;

        if ($request->hasFile('image_1') && $request->file('image_1')->isValid()) {
            $file = $request->file('image_1');
            $extension = $file->extension();
            $fileName = 'giveaway_' . time() . '.' . $extension;
            $file->move($destinationPath, $fileName);
            $imageFileName = $fileName;
        }


        // Create a new giveaway with the specified data
        $giveawayData = [
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'user_winner_id' => $validatedData['user_winner_id'] === '0' ? null : $validatedData['user_winner_id'],
            'image_url' => '/images/giveaways/' . $imageFileName,
        ];
        // Create a new giveaway with the specified data
        $giveaway = Giveaway::create($giveawayData);

        // Return a success response or redirect as desired
        return redirect()->route('giveaways.index')->with('success', 'Sorteo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Giveaway $giveaway)
    {
        return view('giveaways.show', compact('giveaway'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Giveaway $giveaway)
    {
        return view('giveaways.edit', compact('giveaway'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Giveaway $giveaway)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'user_winner_id' => [
                'nullable', // Require the value to be present and not empty
                function ($attribute, $value, $fail) {
                    if ($value !== null && $value !== '0') {
                        // Check if the user with the given ID exists in the users table
                        $user = User::find($value);

                        if (!$user) {
                            $fail("El usuario no es valido.");
                        }
                    }
                },
            ],
            'image_1' => 'nullable|image|mimes:jpeg,png,webp',
        ]);

        $destinationPath = public_path() . '/images/giveaways';
        $imageOldFilename = $giveaway->image_url;
        $imageFileName;

        if ($request->hasFile('image_1') && $request->file('image_1')->isValid()) {
            $file = $request->file('image_1');
            $extension = $file->extension();
            $fileName = 'giveaway_' . time() . '.' . $extension;
            $file->move($destinationPath, $fileName);
            $imageFileName = $fileName;

            if ($imageOldFilename !== null) {
                $oldImagePath = public_path($imageOldFilename);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }else{
            $imageFileName = basename($giveaway->image_url);
        }


        // Create a new giveaway with the specified data
        $giveawayData = [
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'user_winner_id' => $validatedData['user_winner_id'] === '0' ? null : $validatedData['user_winner_id'],
            'image_url' => '/images/giveaways/' . $imageFileName,
        ];
        // Create a new giveaway with the specified data
        $giveaway = Giveaway::create($giveawayData);

        // Return a success response or redirect as desired
        return redirect()->route('giveaways.index')->with('success', 'Sorteo creado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Giveaway $giveaway)
    {
        // Store old image URLs in a separate array
        $imageGiveaway = $giveaway->image_url;

        if ($imageGiveaway !== null) {
            $ImagePath = public_path($imageGiveaway);
            if (file_exists($ImagePath)) {
                unlink($ImagePath);
            }
        }

        // Delete the specified Category
        $giveaway->delete();
        // Return a success response or redirect as desired
        return redirect()->route('giveaways.index')->with('success', 'Sorteo borrado exitosamente.');
    }

    public function winner(Giveaway $giveaway)
    {
        $giveawayWinners = Giveaway_participants::where('giveaway_id', $giveaway->id)->get();
        if($giveawayWinners->count() == 0){
            return redirect()->route('giveaways.index')->with('error', 'No hay participantes en este sorteo.');
        }
        $giveaway->user_winner_id = $giveawayWinners->random()->user_id;
        $giveaway->save();
        return redirect()->route('giveaways.index')->with('success', 'Ganador generado exitosamente exitosamente.');
    }
}
