<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

//Display API Menu
Route::get('/', function () {
    return view('api-menu');
});

//Named Route for Login
//////Route::get('/login', function () {
    //return response()->json(['message' => 'Unauthenticated Son of God'], 401);
//})->name('login');
