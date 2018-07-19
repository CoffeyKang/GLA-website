<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test','inventoryController@test');

Auth::routes();

Route::get('/checkout', 'HomeController@index')->name('home');

Route::get('/GLAAdmin','AdminController@index')->name('index');



Route::middleware('auth')->group(function () {
    
    Route::get('/home','AdminController@home');

    Route::get('/top10', 'AdminController@top10');

    Route::get('/orderHistory', 'AdminController@orderHistory');
});
