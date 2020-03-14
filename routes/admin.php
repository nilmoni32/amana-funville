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
    // here auth:admin is admin guard.
    Route::group(['middleware' => ['auth:admin']], function () {

        Route::get('/', function () {
            return view('admin.dashboard.index');
        })->name('dashboard');
    //  for all settings we will use one controller : SettingController
        Route::get('/settings', 'SettingController@index')->name('settings');
        Route::post('/settings', 'SettingController@update')->name('settings.update');


        // List categories route /admin/categories
        // Create category route /admin/categories/create : for creating category form
        // Store category route /admin/categories/store : storing the data into the database
        // Edit category route /admin/categories/{id}/edit : displaying the edit form by searching category id 
        // Update category route /admin/categories/update: update that category id row data 
        // Delete category route /admin/categories/{id}/delete : delete a particular category 

        Route::group(['prefix' => 'categories'], function(){

            Route::get('/', 'CategoryController@index')->name('categories.index');
            Route::get('/create', 'CategoryController@create')->name('categories.create');
            Route::post('/store', 'CategoryController@store')->name('categories.store');
            Route::get('/{id}/edit', 'CategoryController@edit')->name('categories.edit');
            Route::post('/update', 'CategoryController@update')->name('categories.update');
            Route::get('/{id}/delete', 'CategoryController@delete')->name('categories.delete');
        });
        
        
    });

});

