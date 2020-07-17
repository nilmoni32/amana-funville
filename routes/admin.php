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
    
    // admin login request
    Route::get('login', 'LoginController@showLoginForm')->name('login'); 
    Route::post('login', 'LoginController@login')->name('login.post');  
    Route::get('logout', 'LoginController@logout')->name('logout');  
    
    // admin password reset form display and email send
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    // admin password reset
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
     
    

    // To block unauthoized incoming HTTP requests we use middleware.
    // also we have to put this route at the last. 
    // Protecting the dashboard route, so only authenticated admin can load the dashboard view.
    // here auth:admin is admin guard.
    Route::group(['middleware' => ['auth:admin']], function () {

        Route::group(['middleware' => ['can:funville-dashboard']], function () {        
            Route::get('/', function () {
                return view('admin.dashboard.index');
            })->name('dashboard');
        });


        Route::group(['middleware' => ['can:manage-orders']], function () { 
            // Order Management
            Route::group(['prefix' => 'orders'], function () {
                Route::get('/', 'OrderController@index')->name('orders.index');
                Route::get('/edit/{id}', 'OrderController@edit')->name('orders.edit');
                Route::post('/update', 'OrderController@update')->name('orders.update');
                // Route::get('/{order}/show', 'OrderController@show')->name('orders.show');
                Route::get('/search', 'OrderController@search')->name('orders.search');
                Route::get('/invoice/{id}', 'OrderController@generateInvoice')->name('orders.invoice');
            });
            //pos route
            Route::group(['prefix' => 'sales'], function(){
                Route::get('/index', 'SalesController@index')->name('sales.index'); 
                //pos order place
                Route::post('/index', 'SalesController@orderplace')->name('sales.orderplace');
                //pos order invoice
                Route::get('/invoice/{orderId}', 'SalesController@saleInvoice')->name('sales.invoice');
                //ajax route for pos sales.           
                Route::post('/getfoods','SalesController@getFoods')->name('sales.getfoods');
                Route::post('/foods/addsales','SalesController@addToSales')->name('sales.addtosales');
                Route::post('/cart/update', 'SalesController@update')->name('sales.saleCartUpdate');
                Route::post('/cart/delete', 'SalesController@destroy')->name('sales.saleCartDelete');

                Route::post('/customer/mobile','SalesController@getMobileNo')->name('sales.customermobile');
                Route::post('/customer/info','SalesController@addCustomerInfo')->name('sales.customerInfo');
                //end of ajax route for pos sales.
            
            });

        });

        Route::group(['middleware' => ['can:manage-reports']], function () { 
            //reports
            Route::get('/reports/daily', 'ReportController@daily')->name('reports.daily');
            Route::get('/reports/daily/total', 'ReportController@dailyTotal')->name('reports.dailytotal');
            Route::get('/reports/monthly/total', 'ReportController@monthlytotal')->name('reports.monthlytotal');
            Route::get('/reports/yearly/total', 'ReportController@yearlytotal')->name('reports.yearlytotal');
            Route::get('/reports/top20', 'ReportController@top20')->name('reports.top20');
            Route::post('/reports/top20/', 'ReportController@getTop20')->name('reports.getTop20');                
            Route::get('/reports/single', 'ReportController@single')->name('reports.single');
            Route::post('/reports/single', 'ReportController@singleSale')->name('reports.singleSale');

            //print-pdf-reports
            Route::get('/report/daily/pdf', 'ReportController@pdfdaily')->name('reports.pdfdaily');
            Route::get('/reports/daily/total/pdf', 'ReportController@pdfDailyTotal')->name('reports.pdfdailytotal');
            Route::get('/reports/monthly/total/pdf', 'ReportController@pdfMonthlyTotal')->name('reports.pdfmonthlytotal');
            Route::get('/reports/yearly/total/pdf', 'ReportController@pdfYearlyTotal')->name('reports.pdfyearlytotal');
            Route::get('/reports/top20/pdf/{date1}/{date2}', 'ReportController@pdfGetTop20')->name('reports.pdfgetTop20');
            Route::get('/reports/single/pdf/{date1}/{date2}/{search}', 'ReportController@pdfSingleSale')->name('reports.pdfSingleSale'); 

            //excel reports
            Route::get('/report/daily/excel', 'ReportController@exceldaily')->name('reports.exceldaily');
            Route::get('/reports/daily/total/excel', 'ReportController@excelDailyTotal')->name('reports.exceldailytotal');
            Route::get('/reports/monthly/total/excel', 'ReportController@excelMonthlyTotal')->name('reports.excelmonthlytotal');
            Route::get('/reports/yearly/total/excel', 'ReportController@excelYearlyTotal')->name('reports.excelyearlytotal');
            Route::get('/reports/top20/excel/{date1}/{date2}', 'ReportController@excelGetTop20')->name('reports.excelgetTop20');
            Route::get('/reports/single/excel/{date1}/{date2}/{search}', 'ReportController@excelSingleSale')->name('reports.excelSingleSale');
        });


        Route::group(['middleware' => ['can:all-admin-features']], function () {  

            //  for all settings we will use one controller : SettingController
            Route::get('/settings', 'SettingController@index')->name('settings');
            Route::post('/settings', 'SettingController@update')->name('settings.update');
            // for manage Districts 
            Route::get('/districts', 'DistrictController@index')->name('districts.index');
            Route::post('/districts', 'DistrictController@districtUpdate');
            
            // for manage Zones 
            Route::get('/districts/zones', 'ZoneController@index')->name('zones.index');
            Route::get('/districts/zones/{id}', 'ZoneController@getZones')->name('zones.getall');
            Route::post('/districts/zones', 'ZoneController@zoneUpdate');

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
                // edit product attribute to the current product
                Route::get('/{id}/edit', 'ProductAttributeController@edit')->name('products.attribute.edit');
                // update product attribute to the current product
                Route::post('/update', 'ProductAttributeController@update')->name('products.attribute.update');
                // Delete product attribute from the current product
                Route::get('/{id}/delete', 'ProductAttributeController@delete')->name('products.attribute.delete');
            });

            // Add Users  
            Route::get('/adduser', 'AddUserController@showAddUserForm')->name('adduser.form'); 
            Route::post('/adduser', 'AddUserController@saveUser')->name('adduser.save'); 
            // Users Role  
            Route::get('/role/users', 'RoleUserController@index')->name('users.index');
            Route::get('/role/users/{id}/edit','RoleUserController@edit')->name('users.edit');
            Route::post('/role/users', 'RoleUserController@update')->name('users.update');
            Route::get('/role/users/{id}', 'RoleUserController@destroy')->name('users.destroy');
            // Route::resource('/role/users', 'RoleUserController', ['except' => ['show','create', 'store']]);

            // Add Services
            Route::group(['prefix' => 'services'], function(){  
            Route::get('/create', 'ServiceController@create')->name('services.create'); 
            Route::post('/store', 'ServiceController@store')->name('services.store');
            Route::get('/all', 'ServiceController@index')->name('services.index'); 
            Route::get('/{id}/edit','ServiceController@edit')->name('services.edit');
            Route::post('/update', 'ServiceController@update')->name('services.update');
            Route::get('/{id}/delete', 'ServiceController@delete')->name('services.delete');
            });

        });

        
    });
    

});

