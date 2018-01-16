<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/inventory', 'InventoryController@index');

Route::get('/makes','MakeController@index');

Route::get('/product_list/{make}/{myCurrentPage}','InventoryController@product_list');

Route::get('/item/{item}','InventoryController@singleItem');

Route::get('/related/{item}','InventoryController@related');
