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
use App\Section;
use App\CmsPage;
use App\AboutPage;
use App\CataloguePage;


// Auth::routes();

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
        Route::post('append-prime-categories-level','ProductController@appendPrimeCategoryLevel');


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

        // cms pages
        Route::get('cms-pages','CmsController@CmsPages');
        Route::match(['get', 'post'], 'add-edit-cms-page/{id?}', 'CmsController@addEditCmsPage');
        Route::post('update-cms-page-status', 'CmsController@updateCmsPageStatus');
        Route::get('delete-cms-page/{id}','CmsController@deleteCmsPage');

         // about pages
         Route::get('about-pages','AboutController@AboutPages');
         Route::get('delete-infographic-image/{id}','AboutController@deleteInfographicImage');
         Route::match(['get', 'post'], 'add-edit-about-page/{id?}', 'AboutController@addEditAboutPage');
         Route::post('update-about-page-status', 'AboutController@updateAboutPageStatus');
         Route::get('delete-about-page/{id}','AboutController@deleteAboutPage');

        // catalogue pages
        Route::get('catalogue-pages','CatalogueController@CataloguePages');
        Route::get('delete-catalogue-file/{id}','CatalogueController@deleteCatalogueFile');
        Route::match(['get', 'post'], 'add-edit-catalogue-page/{id?}', 'CatalogueController@addEditCataloguePage');
        Route::post('update-catalogue-page-status', 'CatalogueController@updateCataloguePageStatus');
        Route::get('delete-catalogue-page/{id}','CatalogueController@deleteCataloguePage');

        // Coupons 
        Route::get('coupons', 'CouponsController@coupons');
        Route::post('update-coupon-status', 'CouponsController@updateCouponStatus');
        Route::match(['get', 'post'], 'add-edit-coupon/{id?}', 'CouponsController@addEditCoupon');
        Route::get('delete-coupon/{id}','CouponsController@deleteCoupon');

        // Orders
        Route::get('orders', 'OrdersController@orders');
        Route::get('orders/{id}', 'OrdersController@orderDetails');
        Route::post('update-order-status','OrdersController@updateOrderStatus');

    });
});

// frontend routes
Route::namespace('Front')->group(function(){
    // home page route
   Route::get('/','IndexController@index');
    
   // listing page route
   /* get categorys url */
    $catUrls = Category::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    foreach ($catUrls as $url){
        Route::get('/'.$url,'ProductsController@listing');
    }
    /* get sections url */
    $SecUrls = Section::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    foreach ($SecUrls as $SecUrl){
        Route::get('/'.$SecUrl,'ProductsController@Section');
    }

    // cms page route
    /* get cms pages url */
    $cmsUrls = CmsPage::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    foreach ($cmsUrls as $url){
        Route::get('docs/'.$url,'CmsController@CmsPage');
    }

    // about page route
    /* get about pages url */
    $aboutUrls = AboutPage::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    foreach ($aboutUrls as $url){
        Route::get('about-us/'.$url,'AboutController@AboutPage');
    }

    // catalogue page route
    /* get catalogue pages url */
    $catalogueUrls = CataloguePage::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    foreach ($catalogueUrls as $url){
        Route::get('catalogues/'.$url,'CatalogueController@CataloguePage');
    }

    // contact us page route
    Route::match(['get', 'post'], '/contact-us', 'CmsController@contact');


    // detail page route
    Route::get('/products/{id}','ProductsController@detail');

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
    // Route::post('/add-to-cart-hhose', 'ProductsController@addtocarthhose');
    Route::post('/add-to-cart-shimge', 'ProductsController@addtocartshimge');

    // Get price quotation
    Route::match(['get', 'post'],'/price-quotation', 'ProductsController@getPriceQuotation');
    Route::match(['get', 'post'],'/stock-refill', 'ProductsController@getStockRefill');

    // shopping cart route
    Route::get('/cart','ProductsController@cart');

    // update cart item
    Route::post('/update-cart-item-qty','ProductsController@updateCartItemQty');
    Route::post('/delete-cart-item','ProductsController@deleteCartItem');

    // login/register page
    Route::get('/login-register',['as'=>'login','uses'=>'UsersController@loginRegister']);
    Route::post('/login', 'UsersController@loginUser');
    Route::match(['get', 'post'], '/check-email', 'UsersController@checkEmail');
    Route::match(['get', 'post'], '/check-mobile', 'UsersController@checkMobile');
    Route::post('/register', 'UsersController@registerUser');

    Route::group(['middleware'=>['auth']], function(){
        Route::match(['get', 'post'],'/my-account', 'UsersController@account');
        Route::match(['get', 'post'],'/update-user-pwd', 'UsersController@updateUserPassword');
        Route::post('/check-user-pwd', 'UsersController@chkUserPassword');
        Route::post('/apply-coupon', 'ProductsController@applyCoupon');

        Route::match(['get','post'], '/checkout', 'ProductsController@checkout');
        
        Route::match(['get','post'], '/add-edit-delivery-address/{id?}', 'ProductsController@addEditDeliveryAddress');
        Route::get('/delete-delivery-address/{id}', 'ProductsController@deleteDeliveryAddress');

        Route::post('/append-districts-level','UsersController@appendDistrictLevel');
        Route::post('/append-wards-level','UsersController@appendWardLevel');

        Route::get('/orders', 'OrdersController@orders');
        Route::get('/orders/{id}', 'OrdersController@orderDetails');
    });

    Route::match(['get','post'], '/checkout-for-non-user', 'ProductsController@checkOutForNonUser');
    
    Route::get('/thanks','ProductsController@thanks');

    Route::get('/logout', 'UsersController@logoutUser');
    Route::match(['get', 'post'],'/confirm/{code}', 'UsersController@confirmUser');
    Route::match(['get', 'post'],'/forgot-pwd', 'UsersController@forgotPwd');
});

// use App\Http\Controllers\Admin\ProductController;
// Route::get('/product/{id}', [ProductController::class, 'show']);