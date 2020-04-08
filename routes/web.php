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
Route::get('/about', 'Site\PagesController@about')->name('about');


Auth::routes(['verify' => true]);
// verify token for account activation
Route::post('/verify', 'Site\VerificationController@verify')->name('verify');
//forgot password
Route::post('/postforgot', 'Auth\ForgotPasswordController@postforgot')->name('postforgot');
//verify token for user password reset
Route::get('/verifytoken','Auth\VerificationTokenController@verifytoken')->name('verifytoken');
Route::post('/postverifytoken','Auth\VerificationTokenController@postverifytoken')->name('postverifytoken');
//Reset Password
Route::resource('/resetpassword', 'Auth\ResetPasswordController');


