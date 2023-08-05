<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetCode;
use App\Mail\RegisterCode;

class AuthenticationPublicController extends Controller
{
    public function publicLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if the user's email is verified
            if ($user->email_verified_at !== null) {
                // Generate a random token and store it in the user model
                $user->api_token = Str::random(60); // Or use any method to generate a unique token
                // now adds One ore and set expired date of token
                $user->api_token_expired_date = now()->addHours(1);
                $user->save();

                return response()->json(['token' => $user->api_token], 200);
            } else {
                // If email is not verified, deny login
                return response()->json(['error' => 'Cuenta no verificada, revisa tu correo electronico'], 403);
            }
        } else {
            return response()->json(['error' => 'Correo o Contraseña invalidos'], 403);
        }
    }

    public function publicRegister(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
            ]);

            $name = $request->input('name');
            $email = $request->input('email');

            $tokenRegister = Str::random(4);

            $registerCode =  new RegisterCode($name, $tokenRegister);
            Mail::to($email)->send($registerCode);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'role' => User::ROLE_USER,
                'recover_token' => $tokenRegister
            ]);

            return response()->json(['message' => 'Usuario registrado exitosamente'], 201);

        }catch (\Exception $e){
            // Handle any exceptions that occurred during registration
            return response()->json(['error' => 'Error al registrar el usuario'], 500);
        }
    }

    public function validateRegistration(Request $request){
        $token = $request->query('token');

        $user = User::where('recover_token',$token)->first();

        if($user){
            $user->email_verified_at = now();
            $user->recover_token = null;
            $user->save();
            return response()->json(['message' => 'Usuario registrado exitosamente'], 200);
        }

        return response()->json(['error' => 'Codigo Invalido'], 404);
    }

    public function recoverPassword(Request $request){

        $email = $request->query('email');

        if(!$email){
            return response()->json(['error' => 'Email es requerido'], 403);
        }

        $user = User::where('email', $email)->first();
        if($user){
            $user->recover_token = Str::random(4);
            $user->save();

            $resetCode =  new ResetCode($user->name, $user->recover_token);
            Mail::to($email)->send($resetCode);

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
