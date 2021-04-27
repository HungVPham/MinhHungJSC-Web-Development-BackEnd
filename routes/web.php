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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/admin')->namespace('Admin')->group(function(){
    // All the admin routes will be defined here :~

    Route::match(['get', 'post'],'/','AdminController@login');

    Route::group(['middleware'=>['admin']],function(){

        Route::get('dashboard','AdminController@dashboard');
        Route::get('settings','AdminController@settings');
        Route::get('logout','AdminController@logout');
        Route::post('check-current-pwd', 'AdminController@checkCurrentPassword');
        Route::post('update-current-pwd', 'AdminController@updateCurrentPassword');
        Route::match(['get', 'post'], 'update-admin-details', 'AdminController@updateAdminDetails');

        // Sections
        Route::get('sections','SectionController@sections');
        Route::post('update-section-status', 'SectionController@updateSectionStatus');
        Route::match(['get', 'post'], 'add-edit-section/{id?}', 'SectionController@addEditSection');

        // Categories
        Route::get('categories', 'CategoryController@categories');
        Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
        Route::match(['get', 'post'], 'add-edit-category/{id?}', 'CategoryController@addEditCategory');

        Route::post('append-categories-level','CategoryController@appendCategoryLevel');
        Route::get('delete-section-image/{id}','SectionController@deleteSectionImage');
        Route::get('delete-category/{id}','CategoryController@deleteCategory');
        Route::get('delete-section/{id}','SectionController@deleteSection');

        // Products
        Route::get('products','ProductController@products');
        Route::post('update-product-status', 'ProductController@updateProductStatus');
        Route::get('delete-product/{id}','ProductController@deleteProduct');
        Route::match(['get', 'post'], 'add-edit-product/{id?}', 'ProductController@addEditProduct');

        // delete product images
        Route::get('delete-product-image/{id}','ProductController@deleteProductImage');
        //Route::get('delete-product-image1/{id}','ProductController@deleteProductImage1');
        //Route::get('delete-product-image2/{id}','ProductController@deleteProductImage2');
        //Route::get('delete-product-image3/{id}','ProductController@deleteProductImage3');

        // delete product video
        Route::get('delete-product-video/{id}','ProductController@deleteProductVideo');

        // Products Attribute
        Route::match(['get', 'post'],'add-maxpro-attributes/{id}','ProductController@addMaxproAttributes');
        Route::match(['get', 'post'],'add-hhose-attributes/{id}','ProductController@addHhoseAttributes');
        Route::match(['get', 'post'],'add-shimge-attributes/{id}','ProductController@addShimgeAttributes');
    });
});

