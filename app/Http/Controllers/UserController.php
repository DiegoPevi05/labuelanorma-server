<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Retrieve only verified users with pagination
        $usersQuery = User::whereNotNull('email_verified_at')->whereNotIn('role', ['ADMIN']);

        // Check if the email search parameter is provided
        $email = $request->query('email');
        if ($email) {
            // Apply the email filter to the query
            $usersQuery->where('email', 'like', '%' . $email . '%');
        }

        // Paginate the filtered users
        $users = $usersQuery->paginate(10);

        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $users->lastPage())) {
            return redirect()->route('users.index');
        }

        // Pass the search parameter to the view
        $searchParam = $email ? $email : '';

        // Return a view or JSON response as desired
        return view('users.index', compact('users', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Show the form for creating a new user
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data, including the 'role' field
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required|in:' . User::ROLE_USER . ',' . User::ROLE_MODERATOR,
        ]);

        // Create a new user with the specified role
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => $validatedData['role'],
            'email_verified_at' => now(),
        ]);

        // Return a success response or redirect as desired
        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // Show the specified user
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // Show the form for editing the specified user
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required',
            'role' => 'required|in:' . User::ROLE_USER . ',' . User::ROLE_MODERATOR,
        ]);

        // Update user with the specified role
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->role = $validatedData['role'];
        $user->save();

        // Return a success response or redirect as desired
        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // Delete the specified user
        $user->delete();

        // Return a success response or redirect as desired
        return redirect()->route('users.index')->with('success', 'Usuario borrado exitosamente.');
    }
    /**
     * Logout the current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}
