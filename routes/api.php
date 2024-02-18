<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\Authcontroller;
use Illuminate\Support\Facades\Route;

/*
|---------------------------------
| User Routes
|---------------------------------
*/

Route::group(['middleware' => 'auth:api', "prefix" => "user"], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
    Route::put('/{id}', [UserController::class, 'update']);
});

/*
|---------------------------------
| Auth Routes
|---------------------------------
*/
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware('auth')->name('verification.notice');