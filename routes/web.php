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

Route::get('/kang',"AccessControl@kang");

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

    Route::get('/customerList', 'AdminController@customerList');

    Route::get('/pendingQuotes', 'AdminController@pendingQuotes');

    Route::get('/changePassword', 'AdminController@changePassword');

    Route::post('/updatePassword','AdminController@updatePassword');

    Route::get('/updateInfo','AdminController@updateInfo');

    Route::post('/updateInfo','AdminController@updateUser');

    Route::get('/dealerList','AdminController@dealerList');

    Route::get('/dealerHistory','AdminController@dealerHistory');

    Route::get('/dealerHistory/{id}','AdminController@dealerHistory_oneDealer');

    Route::get('/newDealer','AdminController@newDealer');

    Route::post('/newDealer','AdminController@storeDealer');
    
    Route::get('/editDealer/{id}','AdminController@editDealer');

    Route::post('/updateDealer/{id}','AdminController@updateDealer');

    Route::get('/uploadCatalog','AdminController@uploadCatalog');

    Route::get('/shippingOrder/{order_num}','AdminController@shippingOrder');

    Route::post('/updateShipping','AdminController@updateShipping');

    Route::get('/exchangeRate','AdminController@exchangeRate');
    
    Route::get('/updateExchangeRate','AdminController@updateExchangeRate');

    Route::post('/changeTaxRate','AdminController@changeTaxRate');

    Route::get('/featureProducts','AdminController@featureProducts');

    Route::post('/addNewFeatureProduct','AdminController@addNewFeatureProduct');

    Route::get('/deletefeatureItem/{id}','AdminController@deletefeatureItem');
});
