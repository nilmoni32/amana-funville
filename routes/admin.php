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
            Route::get('/edit/{id}', 'CategoryController@edit')->name('categories.edit');
            Route::post('/update', 'CategoryController@update')->name('categories.update');
            Route::get('/delete/{id}', 'CategoryController@delete')->name('categories.delete');
        });

        Route::group(['prefix' => 'products'], function(){
            Route::get('/', 'ProductController@index')->name('products.index');
            Route::get('/create', 'ProductController@create')->name('products.create');
            Route::post('/store', 'ProductController@store')->name('products.store');
            Route::get('/{id}/edit', 'ProductController@edit')->name('products.edit');
            Route::post('/update', 'ProductController@update')->name('products.update');
            Route::get('/{id}/delete', 'ProductController@delete')->name('products.delete');
        });
        // creating the required routes for image uploading and delete using dropzone.
        Route::group(['prefix' => 'images'], function(){
            Route::post('/upload', 'ProductImageController@upload')->name('products.images.upload');
            Route::get('/{id}/delete', 'ProductImageController@delete')->name('products.images.delete');
        });
        
        Route::group(['prefix' => 'attributes'], function(){   
            // list all the attributes of the current product     
            Route::get('/{id}', 'ProductAttributeController@index')->name('products.attribute.index');
            // create attribute form for the current product
            Route::get('/{id}/create', 'ProductAttributeController@create')->name('products.attribute.create');
            // Add product attribute to the current product
            Route::post('/store', 'ProductAttributeController@store')->name('products.attribute.store');
            // Delete product attribute from the current product
            Route::get('/{id}/delete', 'ProductAttributeController@delete')->name('products.attribute.delete');
        });
        
    });

});

