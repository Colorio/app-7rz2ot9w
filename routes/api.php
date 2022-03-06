<?php

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

Route::namespace('\App\Http\Controllers\Api')->group(function(){
    Route::get('ping', function(){
        return response()->json(["status" => "connected", "time" => now()]);
    });

    Route::resource('products', 'ProductsController')->only(["index","show","store","update","destroy"]);
    Route::post('inventoryMaintenance', "InventoryController@maintenance");
    Route::post('setInventoryAmount', "InventoryController@setAmount");
    Route::get('inventoryHistory/{sku}', "InventoryController@history");

    Route::any('{path}', function() {
	    return response()->json(["status" => 'error', "documentation" => env("APP_URL_API", "localhost:8000"), "errors" => ['404: ENDPOINT inválido. Verique os dados ou entre em contato (54) 99947-9564']], 404);
	})->where('path', '.*');
});