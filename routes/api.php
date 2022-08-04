<?php

use App\Http\Controllers\Api\User;
use Illuminate\Http\Request;
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
Route::get('user',[User::class, 'user']);
Route::get('user/{id}',[User::class,'userById']);
Route::post('userstore',[User::class,'userstore']);
Route::post('userupdate/{id}',[User::class,'update']);
Route::get('userdelete/{id}',[User::class,'delete']);
