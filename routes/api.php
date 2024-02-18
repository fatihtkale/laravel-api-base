<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Authcontroller;

/*
|---------------------------------
| User Routes
|---------------------------------
*/
Route::get('/user', [UserController::class, 'show']);
Route::post('/user/', [UserController::class, 'store']);
Route::get('/user/{id}', [UserController::class, 'index']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);
Route::put('/user/{id}', [UserController::class, 'update']);

/*
|---------------------------------
| Auth Routes
|---------------------------------
*/
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);