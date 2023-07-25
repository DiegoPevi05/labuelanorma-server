<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Giveaway;
use App\Models\Giveaway_participants;
use App\Models\User;

class GiveawayParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $giveawayparticipantsQuery = Giveaway_participants::query();

        // Check if the name search parameter is provided
        $userId = $request->query('userid');
        if ($userId) {
            // Apply the name filter to the query
            $giveawayparticipantsQuery->where('user_id', '=', $userId);
        }

        // Paginate the products
        $giveawayparticipants = $giveawayparticipantsQuery->paginate(10);


        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $giveawayparticipants->lastPage())) {
            return redirect()->route('giveawayparticipants.index');
        }

        $searchParam = $userId ? $userId : '';

        // Return a view or JSON response as desired
        return view('giveawayparticipants.index', compact('giveawayparticipants', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $giveaways = Giveaway::all();
        return view('giveawayparticipants.create',compact ('giveaways'));
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
            'giveaway_id' => [
                'required', // Require the value to be present and not empty
                function ($attribute, $value, $fail) {
                    // Check if the user with the given ID exists in the users table
                    $giveaway = Giveaway::find($value);

                    if (!$giveaway) {
                        $fail("El sorteo no es valido.");
                    }
                },
            ],
            'user_id' => [
                'required', // Require the value to be present and not empty
                function ($attribute, $value, $fail) {
                    // Check if the user with the given ID exists in the users table
                    $user = User::find($value);

                    if (!$user) {
                        $fail("El usuario no es valido.");
                    }
                },
            ],
        ]);
        // Create a new giveaway with the specified data
        $giveawayparticipantData = [
            'giveaway_id' => $validatedData['giveaway_id'],
            'user_id' => $validatedData['user_id'],
        ];
        // Create a new giveaway with the specified data
        $giveawayParticipant = Giveaway_participants::create($giveawayparticipantData);

        // Return a success response or redirect as desired
        return redirect()->route('giveawayparticipants.index')->with('success', 'Participante de Sorteo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Giveaway_participants $giveawayparticipant)
    {
        return view('giveawayparticipants.show', compact('giveawayparticipant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Giveaway_participants $giveawayparticipant)
    {
        $giveaways = Giveaway::all();
        return view('giveawayparticipants.edit', compact('giveawayparticipant', 'giveaways'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Giveaway_participants $giveawayparticipant)
    {
        $validatedData = $request->validate([
            'giveaway_id' => [
                'required', // Require the value to be present and not empty
                function ($attribute, $value, $fail) {
                    // Check if the user with the given ID exists in the users table
                    $giveaway = Giveaway::find($value);

                    if (!$giveaway) {
                        $fail("El sorteo no es valido.");
                    }
                },
            ],
            'user_id' => [
                'required', // Require the value to be present and not empty
                function ($attribute, $value, $fail) {
                    // Check if the user with the given ID exists in the users table
                    $user = User::find($value);

                    if (!$user) {
                        $fail("El usuario no es valido.");
                    }
                },
            ],
        ]);

        $giveawayparticipant->update([
            'giveaway_id' => $validatedData['giveaway_id'],
            'user_id' => $validatedData['user_id'],

        ]);

        // Return a success response or redirect as desired
        return redirect()->route('giveawayparticipants.index')->with('success', 'Participante de Sorteo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Giveaway_participants $giveawayparticipant)
    {
        // Delete the specified Category
        $giveawayparticipant->delete();
        // Return a success response or redirect as desired
        return redirect()->route('giveawayparticipants.index')->with('success', 'Participante de Sorteo borrado exitosamente.');
    }
}
