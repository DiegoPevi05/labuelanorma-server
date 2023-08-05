<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthenticationPublicController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\GiveawayParticipantController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Giveaway;
use App\Models\Giveaway_participants;
use App\Models\Subscriber;
use App\Http\Controllers\WebPublicController;



Route::group(['middleware' => 'api'],function(){

    // Public login endpoint
    Route::post('/login', [AuthenticationPublicController::class, 'publicLogin']);

    // Registration endpoint
    Route::post('/register', [AuthenticationPublicController::class, 'publicRegister']);

    // Activation Account
    Route::post('/validate-account', [AuthenticationPublicController::class, 'validateRegistration']);

    // Recover Password endpoint
    Route::post('/recover-password', [AuthenticationPublicController::class, 'recoverPassword']);

    //Validate token endpoint
    Route::post('/validate-token', [AuthenticationPublicController::class, 'validateCode']);

    // Reset Password endpoint
    Route::post('/reset-password', [AuthenticationPublicController::class, 'resetPassword']);

    // Send contact form from the page
    Route::post('/send-email', [EmailController::class, 'sendEmail']);

    // Route to get web data
    Route::get('/web-data', [WebPublicController::class, 'GetWebData']);
    //Route to get Categories
    Route::get('/categories',[WebPublicController::class,'GetCategories']);
    // Route to validate discount code
    Route::get('/validate-discount-code', [WebPublicController::class, 'ValidateDiscountCode']);
    //Route to get Products
    Route::get('/products-public', [WebPublicController::class, 'GetProductsByFilter']);

    //Route to get Giveawas
    Route::get('/giveaways-all', [WebPublicController::class, 'GetGiveaways']);



    Route::middleware('validateAccessToken')->group(function () {
        Route::get('/user', function (Request $request) {
            $user = $request->user; // Retrieve the authenticated user from the request

            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]);
        });

        //Route to get Giveawas
        Route::get('/giveaways-user', [WebPublicController::class, 'GetGiveawaysAuthorized']);

        route::post('/giveaway-participate', function(Request $request){
            if($request->user_id != $request->user->id ){
                return response()->json([
                    'message' => 'No estas permitido de realizar esta acción'
                ], 403);
            }

            if(!Giveaway::where('id', $request->giveaway_id)->exists()){
                return response()->json([
                    'message' => 'El sorteo no existe'
                ], 404);
            }

            if(Giveaway_participants::where('giveaway_id', $request->giveaway_id)->where('user_id',$request->user->id)->exists() ){
                return response()->json([
                    'message' => 'Ya estas participando del sorteo'
                ], 403);
            }else{
                $giveawayparticipantData = [
                    'giveaway_id' => $request->giveaway_id,
                    'user_id' =>$request->user->id,
                ];
                $giveawayParticipant = Giveaway_participants::create($giveawayparticipantData);
                return response()->json([
                    'message' => 'Te has inscrito correctamente al sorteo'
                ], 201);
            }
        });

        route::post('/subscribe', function(Request $request){
            if($request->user_id != $request->user->id ){
                return response()->json([
                    'message' => 'No estas permitido de realizar esta acción'
                ], 403);
            }else if(Subscriber::where('email', $request->user->email)->exists()){
                return response()->json([
                    'message' => 'Ya estas suscripto'
                ], 403);
            }else{
                Subscriber::create([
                    'user_id' => $request->user->id,
                ]);
                return response()->json([
                    'message' => 'Te has suscripto correctamente a la abuela norma'
                ], 201);
            }
        });
    });
});
