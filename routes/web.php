<?php

require 'admin.php'; // adding admin php with web.php
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

//Route::view('/', 'site.pages.homepage');
Route::get('/', 'Site\PagesController@index')->name('index');

//other pages
Route::get('/about', 'Site\PagesController@about')->name('about');
Route::get('/reservation', 'Site\PagesController@reservation')->name('reservation');
Route::get('/contact', 'Site\PagesController@contact')->name('contact');

//Authentication
Auth::routes(['verify' => true]);
// verify token for account activation
Route::post('/verify', 'Auth\VerificationTokenController@verify')->name('verify');
//forgot password
Route::post('/postforgot', 'Auth\ForgotPasswordController@postforgot')->name('postforgot');
//verify token for user password reset
Route::get('/verifytoken','Auth\VerificationTokenController@verifytoken')->name('verifytoken');
Route::post('/postverifytoken','Auth\VerificationTokenController@postverifytoken')->name('postverifytoken');
//Reset Password
Route::resource('/resetpassword', 'Auth\ResetPasswordController');

//Product Routes 
Route::get('/category/all', 'Site\ProductController@index')->name('products.index');
Route::get('/category/{slug}', 'Site\ProductController@categoryproductshow')->name('categoryproduct.show');
Route::get('/search', 'Site\ProductController@search')->name('search');

//Cart Routes

Route::get('/cart', 'Site\CartController@index')->name('cart.index');  
// this is for home cart store
Route::post('/cart/store', 'Site\CartController@store')->name('cart.store');
// this is for category cart store
Route::post('/category/cart/store', 'Site\CartController@store')->name('cart.store');
Route::post('/cart/update', 'Site\CartController@update')->name('cart.update');
Route::post('/cart/delete', 'Site\CartController@destroy')->name('cart.delete');




