<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('todos', '\App\Http\Controllers\TodoController')->except(['edit', 'create'])->middleware('auth:sanctum');;


Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email', 'exists:users,email'],
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    return response()->json(['access_token' => $user->createToken($request->device_name)->plainTextToken]);
});
