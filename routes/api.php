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
Route::get('/getFileNumbers/{make}','InventoryController@getFileNumbers');
// get inventory
Route::get('/inventory', 'InventoryController@index')->middleware('auth:api');
// make list
Route::get('/makes','MakeController@index');
// products list
Route::get('/product_list/{make}/{myCurrentPage}','InventoryController@product_list');
// single item
Route::get('/item/{item}','InventoryController@singleItem');
// realted items
Route::get('/related/{item}','InventoryController@related');

// get web banner
Route::get('/banner','BannerController@index');

// get web ads
Route::get('/ads','AdController@index');
// get feature products
Route::get('/featureProducts','InventoryController@featureProducts');

// get most popular products
Route::get('/popular','InventoryController@popularProducts');

// search items
Route::get('/searchResualt', 'InventoryController@searchResualt');

Route::get('/wishlist','ShoppingController@wishlist');

Route::get('/wishlist_dealer','ShoppingController@wishlist_dealer');

Route::post('/getItems_carts','InventoryController@getItems_carts');
/**
 * login
 */
Route::post('/loginCustomer','AccessControl@userinfo');

/** create new customer */
Route::post('/newCustomer','AccessControl@newCustomer');

/** create new customer */
Route::post('/resetPassword','AccessControl@resetPassword');

// userdetails
Route::post('/userDetails','AccessControl@userDetails');

// remove from wishlist
Route::post('/removeFromWishlist','InventoryController@removeFromWishlist');

Route::post('/removeFromWishlist_dealer','InventoryController@removeFromWishlist_dealer');
// add To wishlist
Route::post('/addToWishlist','InventoryController@addToWishlist');

//delete all wishlist
Route::post('/clearWishlist','InventoryController@clearWishlist');

//delete all wishlist
Route::post('/clearWishlist_dealer','InventoryController@clearWishlist_dealer');

/** start checkout,
 * process steps
 * 1. insert shipping cart items in to temp_so,
 * 2. turn to php page.
 * 3. calculate shipping
 * 4. ditermin the price level
 * 5. payment
 * 6. finish order
 */
Route::post('/checkout','InventoryController@checkout');

Route::post('/checkoutDealer','InventoryController@checkoutDealer');

Route::get('/shortlist','InventoryController@shortlist');

/** get shortlist items and total no shipping estimationg */


/** add new shipping address */
Route::post('/newShippingAdd','InventoryController@newShippingAdd');

/** add new shipping address */
Route::post('/deleteAddress','InventoryController@deleteAddress');

/** change address */
Route::post('/changeAddress','InventoryController@changeAddress');

/** get customer so history */
Route::get('/customerOrderHistory','InventoryController@customerOrderHistory');

Route::get('/customerTrackOrder','InventoryController@customerTrackOrder');

/** get dealer so history */
Route::get('/dealerOrderHistory','InventoryController@dealerOrderHistory');
// oneOrder
Route::get('/oneOrder','InventoryController@oneOrder');

// updateUserInfo
Route::post('/updateUserInfo','AccessControl@updateUserInfo');

// change password 
Route::post('/changePassword','AccessControl@changePassword');

Route::post('/viewed','AdminController@viewed');

Route::get('/catalogs','InventoryController@catalogs');


// realted items
Route::get('/address/{id}','InventoryController@address');

Route::post('/confirmOrder','InventoryController@confirmOrder');

Route::post('/payment','InventoryController@payment');

Route::get('/oneOrder/{sono}','InventoryController@aOrder');

Route::get('/getShortlist/{id}','InventoryController@getShortlist');

Route::get('/deleteShortlist/{id}','InventoryController@deleteShortlist');


Route::post('/checkCaptcha','InventoryController@checkCaptcha');

/** dealer panel */
Route::post('/loginDealer','DealerController@login');

Route::get('/dealerInfo/{id}',"DealerController@dealerInfo");

Route::post('/changePass','DealerController@changePass');


Route::post('/addToWishlist_dealer','InventoryController@addToWishlist_dealer');

// oneOrder
Route::get('/oneOrder_dealer','InventoryController@Order_dealer');

Route::get('/oneOrder_dealer_finish','DealerController@oneOrder_dealer_finish');

Route::get('/DealerShortlist','InventoryController@DealerShortlist');

Route::get('/getShortlist_dealer/{id}','InventoryController@getShortlist_dealer');

Route::post('/dealerConfirm','DealerController@dealerConfirm');

Route::get('/exchangeRate','InventoryController@exchangeRate');


Route::post('/finishOrder','InventoryController@placeOrder');

Route::post('/finishOrder_paypal','InventoryController@placeOrder_paypal');

Route::get('/special/{page}','InventoryController@special');

Route::post('/inquiry','AccessControl@inquiry');





