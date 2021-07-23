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

// Route::get('/', function () {\
//     return view('welcome');
// });
use App\Category;


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

        // sections
        Route::get('sections','SectionController@sections');
        Route::post('update-section-status', 'SectionController@updateSectionStatus');
        Route::match(['get', 'post'], 'add-edit-section/{id?}', 'SectionController@addEditSection');
        Route::get('delete-section/{id}','SectionController@deleteSection');
        Route::get('delete-section-image/{id}','SectionController@deleteSectionImage');

        // brands
        Route::get('brands','BrandController@brands');
        Route::post('update-brand-status', 'BrandController@updateBrandStatus');
        Route::match(['get', 'post'], 'add-edit-brand/{id?}', 'BrandController@addEditBrand');
        Route::get('delete-brand/{id}','BrandController@deleteBrand');

        // categories
        Route::get('categories', 'CategoryController@categories');
        Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
        Route::match(['get', 'post'], 'add-edit-category/{id?}', 'CategoryController@addEditCategory');
        Route::post('append-categories-level','CategoryController@appendCategoryLevel');
        Route::get('delete-category/{id}','CategoryController@deleteCategory');
        

        // products
        Route::get('products','ProductController@products');
        Route::post('update-product-status', 'ProductController@updateProductStatus');
        Route::get('delete-product/{id}','ProductController@deleteProduct');
        Route::match(['get', 'post'], 'add-edit-product/{id?}', 'ProductController@addEditProduct');

        // delete product images
        Route::get('delete-product-image/{id}','ProductController@deleteProductImage');

        // delete product video
        Route::get('delete-product-video/{id}','ProductController@deleteProductVideo');

        // add products attribute
        Route::match(['get', 'post'],'add-maxpro-attributes/{id}','ProductController@addMaxproAttributes');
        Route::match(['get', 'post'],'add-hhose-attributes/{id}','ProductController@addHhoseAttributes');
        Route::match(['get', 'post'],'add-shimge-attributes/{id}','ProductController@addShimgeAttributes');

        // add products attribute
        Route::post('edit-maxpro-attributes/{id}','ProductController@editMaxproAttributes');
        Route::post('edit-hhose-attributes/{id}','ProductController@editHhoseAttributes');
        Route::post('edit-shimge-attributes/{id}','ProductController@editShimgeAttributes');

        // edit product attributes status
        Route::post('update-maxproattributes-status', 'ProductController@updateMaxproAttributesStatus');
        Route::post('update-hhoseattributes-status', 'ProductController@updateHhoseAttributesStatus');
        Route::post('update-shimgeattributes-status', 'ProductController@updateShimgeAttributesStatus');

        // delete product attributes
        Route::get('delete-maxproattributes/{id}','ProductController@deleteMaxproAttributes');
        Route::get('delete-hhoseattributes/{id}','ProductController@deleteHhoseAttributes');
        Route::get('delete-shimgeattributes/{id}','ProductController@deleteShimgeAttributes');

        // add products images 
        Route::match(['get', 'post'],'add-images/{id}','ProductController@addImages');
        Route::post('update-image-status', 'ProductController@updateImageStatus');
        Route::get('delete-image/{id}','ProductController@deleteImage');

        // banners
        Route::get('banners', 'BannersController@banners');
        Route::match(['get', 'post'], 'add-edit-banner/{id?}', 'BannersController@addEditBanner');
        Route::post('update-banner-status', 'BannersController@updateBannerStatus');
        Route::get('delete-banner/{id}','BannersController@deleteBanner');
    });
});

// frontend routes
Route::namespace('Front')->group(function(){
    // home page route
   Route::get('/','IndexController@index');
    
   // listing page route
   /* get category url */
   $catUrls = Category::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    foreach ($catUrls as $url){
        Route::get('/'.$url,'ProductsController@listing');
    }

    // detail page route
    Route::get('/sản-phẩm/{id}','ProductsController@detail');

    // get maxpro attribute price, voltage, power 
    Route::post('/get-maxpro-product-price', 'ProductsController@getMaxproProductPrice');
    Route::post('/get-maxpro-product-voltage', 'ProductsController@getMaxproProductVoltage');
    Route::post('/get-maxpro-product-power', 'ProductsController@getMaxproProductPower');
    Route::post('/get-maxpro-product-stock', 'ProductsController@getMaxproProductStock');

    // get hhose attribute price, diameter, lenght_per_unit, embossed, smoothtexture,  
    Route::post('/get-hhose-product-price', 'ProductsController@getHhoseProductPrice');
    Route::post('/get-hhose-product-diameter', 'ProductsController@getHhoseProductDiameter');
    Route::post('/get-hhose-product-length', 'ProductsController@getHhoseProductLength');
    Route::post('/get-hhose-product-embossed', 'ProductsController@getHhoseProductEmbossed');
    Route::post('/get-hhose-product-smooth', 'ProductsController@getHhoseProductSmooth');
    Route::post('/get-hhose-product-stock', 'ProductsController@getHhoseProductStock');
    
    // get shimge attribute price, voltage, power 
    Route::post('/get-shimge-product-price', 'ProductsController@getShimgeProductPrice');
    Route::post('/get-shimge-product-voltage', 'ProductsController@getShimgeProductVoltage');
    Route::post('/get-shimge-product-power', 'ProductsController@getShimgeProductPower');
    Route::post('/get-shimge-product-maxflow', 'ProductsController@getShimgeProductMaxflow');
    Route::post('/get-shimge-product-vertical', 'ProductsController@getShimgeProductVertical');
    Route::post('/get-shimge-product-indiameter', 'ProductsController@getShimgeProductIndiameter');
    Route::post('/get-shimge-product-outdiameter', 'ProductsController@getShimgeProductOutdiameter');
    Route::post('/get-shimge-product-stock', 'ProductsController@getShimgeProductStock');

    // add to cart route
    Route::post('/add-to-cart-maxpro', 'ProductsController@addtocartmaxpro');
    Route::post('/add-to-cart-hhose', 'ProductsController@addtocarthhose');
    Route::post('/add-to-cart-shimge', 'ProductsController@addtocartshimge');
});

use App\Http\Controllers\Admin\ProductController;
Route::get('/product/{id}', [ProductController::class, 'show']);