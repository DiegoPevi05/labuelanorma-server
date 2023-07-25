<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use App\Models\User;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Retrieve only verified users with pagination
        $subscribersQuery = Subscriber::query();

        // Check if the name search parameter is provided
        $userId = $request->query('userId');
        if ($userId) {
            // Apply the name filter to the query
            $subscribersQuery->where('user_id','=', $userId);
        }

        // Paginate the categories
        $subscribers = $subscribersQuery->paginate(10);

        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $subscribers->lastPage())) {
            return redirect()->route('subscribers.index');
        }

        $searchParam = $userId ? $userId : '';

        // Return a view or JSON response as desired
        return view('subscribers.index', compact('subscribers', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('subscribers.create');
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
            'user_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Check if the User with the given ID exists in the categories table
                    $user = User::find($value);

                    if (!$user) {
                        $fail("El usuario seleccionado no es valido.");
                    }
                },
            ],
        ]);
        // Create a new giveaway with the specified data
        $subscriberData = [
            'user_id' => $validatedData['user_id'],
        ];
        // Create a new giveaway with the specified data
        $subscriber = Subscriber::create($subscriberData);

        // Return a success response or redirect as desired
        return redirect()->route('subscribers.index')->with('success', 'Subscriptor creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        return view('subscribers.show', compact('subscriber'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscriber $subscriber)
    {
        return view('subscribers.edit', compact('subscriber'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscriber $subscriber)
    {
        $validatedData = $request->validate([
            'user_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Check if the User with the given ID exists in the categories table
                    $user = User::find($value);

                    if (!$user) {
                        $fail("El usuario seleccionado no es valido.");
                    }
                },
            ],
        ]);
        // Create a new giveaway with the specified data
        $subscriber->update([
            'user_id' => $validatedData['user_id'],
        ]);
        // Return a success response or redirect as desired
        return redirect()->route('subscribers.index')->with('success', 'Subscriptor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber)
    {
        // Delete the specified Category
        $subscriber->delete();
        // Return a success response or redirect as desired
        return redirect()->route('subscribers.index')->with('success', 'Subscriptor borrado exitosamente.');
    }


}
