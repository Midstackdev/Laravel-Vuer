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

Route::resource('products', 'ProductController');
Route::post('/rating/new', 'DetailController@setRating')->name('setrating');
Route::get('/rating/{id}', 'DetailController@getRating')->name('getrating');
Route::get('/product/search', 'DetailController@search')->name('search');