<?php 

/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
|
| Here is where Admin user can register web routes for this application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Admin','prefix' => 'admin', 'as' => 'admin.'], function(){

    // We are adding a routes group to prefix all our admin routes with /admin. so that get route would be /admin/login.
    // we are adding a routes group to as with named route so that name route would be ('admin.login.post');
    // we are adding a routes group to namespace with controller so that controller name would be Admin\LoginController@showLoginForm.
    
    Route::get('login', 'LoginController@showLoginForm')->name('login'); 
    Route::post('login', 'LoginController@login')->name('login.post');  
    Route::get('logout', 'LoginController@logout')->name('logout');   
    

    // To block unauthoized incoming HTTP requests we use middleware.
    // also we have to put this route at the last. 
    // Protecting the dashboard route, so only authenticated admin can load the dashboard view.
    Route::group(['middleware' => ['auth:admin']], function () {

        Route::get('/', function () {
            return view('admin.dashboard.index');
        })->name('dashboard');
    
    });

});
