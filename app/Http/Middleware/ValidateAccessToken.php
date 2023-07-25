<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ValidateAccessToken
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the request has an "Authorization" header with the Bearer token
        if ($request->header('Authorization')) {
            // Extract the token from the header
            $token = str_replace('Bearer ', '', $request->header('Authorization'));

            // Attempt to retrieve the user based on the token (manually checking credentials) and expired date is greater than now
            $user = User::where('api_token', $token)->first();

            if($user->api_token_expired_date < date('Y-m-d H:i:s')){
                return response()->json(['error' => 'Token Expirado'], 401);
            }

            if ($user) {
                // Set the authenticated user in the request
                $request->merge(['user' => $user]);

                return $next($request);
            }
        }

        // Unauthorized access
        return response()->json(['error' => 'No estas Autorizado'], 401);
    }
}
