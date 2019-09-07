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
    return view('product');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('login/{provider}', 'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');
Route::get('/checkout', 'CheckoutController@index')->name('checkout');
Route::get('/checkout/stripe', 'CheckoutController@stripe')->name('stripe');
Route::post('/checkout/stripepayment', 'CheckoutController@stripePayment')->name('stripepayment');
Route::get('/detail/{id}', 'DetailController@detail')->name('detail');