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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin'], function() {
	// Routes For Auth (login, logout, reset)
    Auth::routes();
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::get('logout', 'Auth\LoginController@logout');

  	// After login Successfuly
    Route::group(['middleware' => 'auth'], function() {
        // After Login Redirect to '/admin'
        Route::get('/',
          [
            'uses'  => 'DashboardsController@index',
            'as'  => 'dashboard'
          ]);

        Route::group(['prefix' => 'users'], function(){
          Route::get('/datatables/users', [
            'uses'  => 'UsersController@getDatatable',
            'as'  => 'datatables.users'
          ]);
          // ajax delete
          Route::get('/delete/{id}', [
            'uses'  => 'UsersController@ajaxDelete',
            'as'  => 'user_destroy'
          ]);
          
          // /admin/users
          Route::get('/', [
            'uses'  => 'UsersController@index',
            'as'  => 'user_index'
          ]);
          // /admin/users/create :GET
          Route::get('/create',[
            'uses'  => 'UsersController@create',
            'as'  => 'user_create'
          ]);
          // /admin/users/create :POST
          Route::post('/create', [
            'uses'  => 'UsersController@store',
            'as'  => 'user_store'
          ]);
          // /admin/users/edit{id} :GET
          Route::get('/edit/{id}', [
            'uses'  => 'UsersController@edit',
            'as'  => 'user_edit'
          ]);
          // /admin/users/edit{id} :POST
          Route::post('/edit/{id}', [
            'uses'  => 'UsersController@update',
            'as'  => 'user_update'
          ]);
          // /admin/users/change_password{id} :GET
          Route::get('/change_password/{id}',[
            'uses'  => 'UsersController@change_password',
            'as'  => 'user_change_password'
          ]);
          // /admin/users/update_password{id} :POST
          Route::post('/update_password/{id}',[
            'uses'  => 'UsersController@update_password',
            'as'  => 'user_change_password_update'
          ]);
          Route::get('/password',[
            'uses'  => 'UsersController@password',
            'as'  => 'users.password'
          ]);
          Route::post('/password',[
            'uses'  => 'UsersController@password',
            'as'  => 'users.password.update'
          ]);
        });

        Route::group(['prefix' => 'categories'], function(){
          Route::get('/datatables/categories', [
            'uses'  => 'CategoryController@getDatatable',
            'as'  => 'datatables.categories'
          ]);
          // ajax delete
          Route::get('/delete/{id}', [
            'uses'  => 'CategoryController@ajaxDelete',
            'as'  => 'category_destroy'
          ]);
          
          // /admin/categories
          Route::get('/', [
            'uses'  => 'CategoryController@index',
            'as'  => 'category_index'
          ]);
          // /admin/categories/create :GET
          Route::get('/create',[
            'uses'  => 'CategoryController@create',
            'as'  => 'category_create'
          ]);
          // /admin/categories/create :POST
          Route::post('/create', [
            'uses'  => 'CategoryController@store',
            'as'  => 'category_store'
          ]);
          // /admin/categories/edit{id} :GET
          Route::get('/edit/{id}', [
            'uses'  => 'CategoryController@edit',
            'as'  => 'category_edit'
          ]);
          // /admin/categories/edit{id} :POST
          Route::post('/edit/{id}', [
            'uses'  => 'CategoryController@update',
            'as'  => 'category_update'
          ]);
        });

        Route::group(['prefix' => 'products'], function(){
          Route::get('/datatables/products', [
            'uses'  => 'ProductController@getDatatable',
            'as'  => 'datatables.products'
          ]);
          // ajax delete
          Route::get('/delete/{id}', [
            'uses'  => 'ProductController@ajaxDelete',
            'as'  => 'product_destroy'
          ]);
          
          // /admin/products
          Route::get('/', [
            'uses'  => 'ProductController@index',
            'as'  => 'product_index'
          ]);
          // /admin/products/create :GET
          Route::get('/create',[
            'uses'  => 'ProductController@create',
            'as'  => 'product_create'
          ]);
          // /admin/products/create :POST
          Route::post('/create', [
            'uses'  => 'ProductController@store',
            'as'  => 'product_store'
          ]);
          // /admin/products/edit{id} :GET
          Route::get('/edit/{id}', [
            'uses'  => 'ProductController@edit',
            'as'  => 'product_edit'
          ]);
          // /admin/products/edit{id} :POST
          Route::post('/edit/{id}', [
            'uses'  => 'ProductController@update',
            'as'  => 'product_update'
          ]);
          // AJAX :::::
          Route::post('/product_search',[
            'uses'  => 'ProductController@ajaxSearchProduct',
            'as'  => 'product_search'
          ]);
        });

        Route::group(['prefix' => 'customers'], function(){
          Route::get('/datatables/customers', [
            'uses'  => 'CustomerController@getDatatable',
            'as'  => 'datatables.customers'
          ]);
          // ajax delete
          Route::get('/delete/{id}', [
            'uses'  => 'CustomerController@ajaxDelete',
            'as'  => 'customer_destroy'
          ]);
          
          // /admin/customers
          Route::get('/', [
            'uses'  => 'CustomerController@index',
            'as'  => 'customer_index'
          ]);
          // /admin/customers/create :GET
          Route::get('/create',[
            'uses'  => 'CustomerController@create',
            'as'  => 'customer_create'
          ]);
          // /admin/customers/create :POST
          Route::post('/create', [
            'uses'  => 'CustomerController@store',
            'as'  => 'customer_store'
          ]);
          // /admin/customers/edit{id} :GET
          Route::get('/edit/{id}', [
            'uses'  => 'CustomerController@edit',
            'as'  => 'customer_edit'
          ]);
          // /admin/customers/edit{id} :POST
          Route::post('/edit/{id}', [
            'uses'  => 'CustomerController@update',
            'as'  => 'customer_update'
          ]);
          // AJAX :::::
          Route::post('/customer_search',[
            'uses'  => 'CustomerController@ajaxSearchCustomer',
            'as'  => 'customer_search'
          ]);
        });

        Route::group(['prefix' => 'reviews'], function(){
          Route::get('/datatables/reviews', [
            'uses'  => 'ReviewController@getDatatable',
            'as'  => 'datatables.reviews'
          ]);
          // ajax delete
          Route::get('/delete/{id}', [
            'uses'  => 'ReviewController@ajaxDelete',
            'as'  => 'review_destroy'
          ]);
          
          // /admin/reviews
          Route::get('/', [
            'uses'  => 'ReviewController@index',
            'as'  => 'review_index'
          ]);
          // /admin/reviews/create :GET
          Route::get('/create',[
            'uses'  => 'ReviewController@create',
            'as'  => 'review_create'
          ]);
          // /admin/reviews/create :POST
          Route::post('/create', [
            'uses'  => 'ReviewController@store',
            'as'  => 'review_store'
          ]);
          // /admin/reviews/edit{id} :GET
          Route::get('/edit/{id}', [
            'uses'  => 'ReviewController@edit',
            'as'  => 'review_edit'
          ]);
          // /admin/reviews/edit{id} :POST
          Route::post('/edit/{id}', [
            'uses'  => 'ReviewController@update',
            'as'  => 'review_update'
          ]);
        });

        Route::group(['prefix' => 'methods'], function(){
          // /admin/methods
          Route::get('/', [
            'uses'  => 'MethodController@index',
            'as'  => 'method_index'
          ]);
           // /admin/categories/create :POST
           Route::post('/create', [
            'uses'  => 'MethodController@store',
            'as'  => 'method_store'
          ]);
        });

    }); // end middle auth
});
