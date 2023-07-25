<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductSizeController;
use App\Http\Controllers\DiscountCodeController;
use App\Http\Controllers\GiveawayController;
use App\Http\Controllers\GiveawayParticipantController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\WebContentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public routes accessible without authentication
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/out', [UserController::class, 'logout'])->name('home.logout');

// Routes requiring authentication
Route::middleware('auth:sanctum')->group(function () {
    // Group for routes accessible to users with the 'USER' role
    Route::middleware('role:' . User::ROLE_USER)->group(function () {
        Route::get('/user', function (Request $request) {
            return 'This is a route accessible to users with the USER role.';
        });
        // Add more routes for users with the 'USER' role...
    });

    // Group for routes accessible to users with the 'MODERATOR' role
    Route::middleware('role:' . User::ROLE_MODERATOR . ',' . User::ROLE_ADMIN)->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('productsizes', ProductSizeController::class);
        Route::resource('discountcodes', DiscountCodeController::class);
        Route::resource('giveaways', GiveawayController::class);
        Route::post('/giveaways/{giveaway}/winner', [GiveawayController::class, 'winner'])->name('giveaways.winner');
        Route::resource('giveawayparticipants', GiveawayParticipantController::class);
        Route::resource('subscribers', SubscriberController::class);
        Route::resource('webcontents', WebContentController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('invoices', InvoiceController::class);
    });
    // Group for routes accessible to users with the 'ADMIN' role
    Route::middleware('role:' . User::ROLE_ADMIN)->group(function () {
        Route::resource('users', UserController::class);
    });
});

Auth::routes();



