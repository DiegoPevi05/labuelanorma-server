<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetCode;

class AuthenticationPublicController extends Controller
{
    public function publicLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Generate a random token and store it in the user model
            $user->api_token = Str::random(60); // Or use any method to generate a unique token
            // now adds One ore and set expired date of token
            $user->api_token_expired_date = now()->addHours(1);
            $user->save();

            return response()->json(['access_token' => $user->api_token], 200);
        } else {
            return response()->json(['error' => 'Credenciales invalidas'], 401);
        }
    }

    public function publicRegister(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => User::ROLE_USER,
            'email_verified_at' => now(),
        ]);

        return response()->json(['message' => 'Usuario registrado exitosamente'], 201);
    }

    public function recoverPassword(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $validatedData['email'])->first();
        if($user){
            $user->recover_token = Str::random(4); 
            $user->save();

            $resetCode =  new ResetCode($user->name, $user->recover_token);
            Mail::to($validatedData['email'])->send($resetCode);

            return response()->json(['message' => 'Se ha enviado un correo con las instrucciones para recuperar su contraseña'], 200);
        }else{
            return response()->json(['error' => 'No se ha encontrado un usuario con ese correo'], 404);
        }
    }

    public function validateCode(Request $request){
        $validateData = $request->validate([
            'email' => 'required|email',
            'recover_token' => 'required',
        ]);

        $user = User::where('email', $validateData['email'])->where('recover_token', $validateData['recover_token'])->first();
        if($user){
            return response()->json(['message' => 'Código valido'], 200);
        }else{
            return response()->json(['error' => 'Código incorrecto'], 404);
        }
    }

    public function resetPassword(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|email',
            'new_password' => 'required',
            'recover_token' => 'required',
        ]);

        $user = User::where('email', $validatedData['email'])->where('recover_token', $validatedData['recover_token'])->first();

        if($user){
            $user->password = bcrypt($validatedData['new_password']);
            $user->recover_token = null;
            $user->save();
            return response()->json(['message' => 'Se ha cambiado la contraseña exitosamente'], 200);
        }else{
            return response()->json(['error' => 'Codigo de recuperación no valido solicita otro'], 404);
        }
    
    }
}
