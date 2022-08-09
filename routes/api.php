<?php

use App\Http\Controllers\Api\ProductApi;
use App\Http\Controllers\Api\User;
use App\Http\Controllers\File\FileController;
use App\Models\Api\Products;
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
//User Api keys
Route::get('user', [User::class, 'user']);
Route::get('user/{id}', [User::class, 'userById']);
Route::post('userstore', [User::class, 'userstore']);
Route::post('userupdate/{id}', [User::class, 'update']);
Route::get('userdelete/{id}', [User::class, 'delete']);

//Product Api keys
Route::get('get-product', [ProductApi::class, 'getallproduct']);
Route::get('get-product/{id}', [ProductApi::class, 'getProductById']);
Route::post('add-product', [ProductApi::class, 'addProduct']);
Route::post('update-product/{id}', [ProductApi::class, 'updateProduct']);
Route::get('deleteproduct/{id}', [ProductApi::class, 'delete']);
