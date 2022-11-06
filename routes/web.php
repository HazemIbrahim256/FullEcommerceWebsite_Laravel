<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AllUserController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\AdminUserController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ProductsController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\ReturnController;
use App\Http\Controllers\Backend\ShippingController;
use App\Http\Controllers\Backend\SiteSettingController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubcategoryController;
use App\Http\Controllers\User\CashController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeBlogController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\User\CartPageController;
use App\Http\Controllers\User\CheckController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\User\StripeController;
use App\Http\Controllers\User\WishlistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Laravel\Jetstream\Rules\Role;

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

Route::get('/', [IndexController::class, 'index']);

Route::group(['prefix' => 'admin', 'middleware'=>['admin:admin']], function(){
    Route::get('/login', [AdminController::class, 'loginForm']);
    Route::post('/login', [AdminController::class, 'store'])->name('admin.login');
});

Route::middleware(['auth:admin'])->group(function(){

    Route::middleware(['auth:sanctum,admin', 'verified'])->get('/admin/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
    // Admin All Routes

Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');
Route::get('/admin/profile', [AdminProfileController::class, 'AdminProfile'])->name('admin.profile');
Route::get('/admin/profile/edit', [AdminProfileController::class, 'AdminProfileEdit'])->name('admin.profile.edit');
Route::post('/admin/profile/update', [AdminProfileController::class, 'AdminProfileUpdate'])->name('admin.profile.update');
Route::get('/admin/change/password', [AdminProfileController::class, 'AdminChangePassword'])->name('admin.change.password');
Route::post('/update/password', [AdminProfileController::class, 'UpdatePass'])->name('update.password');

    // Admin Brands Routes

Route::prefix('/brand')->group(function(){
    Route::get('/view', [BrandController::class, 'BrandView'])->name('all.brand');
    Route::post('/store', [BrandController::class, 'StoreBrand'])->name('brand.store');
    Route::get('/edit/{id}', [BrandController::class, 'BrandEdit'])->name('brand.edit');
    Route::post('/update', [BrandController::class, 'UpdateBrand'])->name('brand.update');
    Route::get('/delete/{id}', [BrandController::class, 'BrandDelete'])->name('brand.delete');

});

// Admin Categories Routes

Route::prefix('/category')->group(function(){
    Route::get('/view', [CategoryController::class, 'CatView'])->name('all.cats');
    Route::post('/store', [CategoryController::class, 'StoreCat'])->name('category.store');
    Route::get('/edit/{id}', [CategoryController::class, 'CatEdit'])->name('category.edit');
    Route::post('/update', [CategoryController::class, 'UpdateCat'])->name('category.update');
    Route::get('/delete/{id}', [CategoryController::class, 'CatDelete'])->name('category.delete');


    // Subcategory

    Route::get('/view/subcategory', [SubcategoryController::class, 'SubcatView'])->name('all.subcats');
    Route::post('/store/subcategory', [SubcategoryController::class, 'StoreSubcat'])->name('subcategory.store');
    Route::get('/edit/subcategory/{id}', [SubcategoryController::class, 'SubcatEdit'])->name('subcategory.edit');
    Route::post('/update/subcategory', [SubcategoryController::class, 'UpdateSubcat'])->name('subcategory.update');
    Route::get('/delete/subcategory/{id}', [SubcategoryController::class, 'SubcatDelete'])->name('subcategory.delete');

    // SubSubcategory

    Route::get('/view/sub/subcategory', [SubcategoryController::class, 'SubsubcatView'])->name('all.subsubcats');
    Route::get('/subcategory/ajax/{category_id}', [SubcategoryController::class, 'GetSubCat']);
    Route::get('/subsubcategory/ajax/{subcategory_id}', [SubcategoryController::class, 'GetSubSubCat']);

    Route::post('/store/subsubcategory', [SubcategoryController::class, 'StoreSubsubcat'])->name('subsubcategory.store');
    Route::get('/edit/subsubcategory/{id}', [SubcategoryController::class, 'SubsubcatEdit'])->name('subsubcategory.edit');
    Route::post('/update/subsubcategory', [SubcategoryController::class, 'UpdateSubsubcat'])->name('subsubcategory.update');
    Route::get('/delete/subsubcategory/{id}', [SubcategoryController::class, 'SubsubcatDelete'])->name('subsubcategory.delete');




});


// Admin Products Routes

Route::prefix('/products')->group(function(){
    Route::get('/add', [ProductsController::class, 'AddProduct'])->name('add.product');
    Route::post('/store', [ProductsController::class, 'StoreProduct'])->name('product.store');
    Route::get('/manage', [ProductsController::class, 'MngProduct'])->name('mng.product');
    Route::get('/edit/{id}', [ProductsController::class, 'EditProduct'])->name('product.edit');
    Route::post('/update', [ProductsController::class, 'UpdateProduct'])->name('product.update');
    Route::post('/images', [ProductsController::class, 'UpdateProductImgs'])->name('update.image');
    Route::post('/thumbnail', [ProductsController::class, 'UpdateProductThmbnl'])->name('update.thumbnail');
    Route::get('/images/delete/{id}', [ProductsController::class, 'DeleteImgs'])->name('product.multiImg.delete');
    Route::get('/inactive/{id}', [ProductsController::class, 'Inactive'])->name('product.inactive');
    Route::get('/active/{id}', [ProductsController::class, 'Active'])->name('product.active');
    Route::get('/details/{id}', [ProductsController::class, 'Details'])->name('product.details');
    Route::get('/delete/{id}', [ProductsController::class, 'ProductDelete'])->name('product.delete');


});

// Slider Routes

Route::prefix('/slider')->group(function(){
    Route::get('/view', [SliderController::class, 'SliderView'])->name('mng.slider');
    Route::get('/inactive/{id}', [SliderController::class, 'Inactive'])->name('slider.inactive');
    Route::get('/active/{id}', [SliderController::class, 'Active'])->name('slider.active');
    Route::post('/store', [SliderController::class, 'StoreSlider'])->name('store.slider');
    Route::get('/edit/{id}', [SliderController::class, 'SliderEdit'])->name('slider.edit');
    Route::post('/update', [SliderController::class, 'UpdateSlider'])->name('slider.update');
    Route::get('/delete/{id}', [SliderController::class, 'SliderDelete'])->name('slider.delete');


});


// Coupons Routes

Route::prefix('/coupons')->group(function(){
    Route::get('/view', [CouponController::class, 'CouponView'])->name('mng.coupon');
    Route::post('/store', [CouponController::class, 'StoreCoupon'])->name('coupon.store');
    Route::get('/edit/{id}', [CouponController::class, 'CouponEdit'])->name('coupon.edit');
    Route::post('/update', [CouponController::class, 'UpdateCoupon'])->name('coupon.update');
    Route::get('/delete/{id}', [CouponController::class, 'CouponDelete'])->name('coupon.delete');


});

Route::prefix('/shipping')->group(function(){
    Route::get('/division/view', [ShippingController::class, 'DivisionView'])->name('mng.division');
    Route::post('/division/store', [ShippingController::class, 'DivisionStore'])->name('division.store');
    Route::get('/division/edit/{id}', [ShippingController::class, 'DivisionEdit'])->name('division.edit');
    Route::post('/division/update', [ShippingController::class, 'DivisionUpdate'])->name('division.update');
    Route::get('/division/delete/{id}', [ShippingController::class, 'DivisionDelete'])->name('division.delete');

    Route::get('/district/view', [ShippingController::class, 'DistrictView'])->name('mng.district');
    Route::get('/district-get/ajax/{division_id}', [ShippingController::class, 'DistrictGet']);
    Route::post('/district/store', [ShippingController::class, 'DistrictStore'])->name('district.store');
    Route::get('/district/edit/{id}', [ShippingController::class, 'DistrictEdit'])->name('district.edit');
    Route::post('/district/update', [ShippingController::class, 'DistrictUpdate'])->name('district.update');
    Route::get('/district/delete/{id}', [ShippingController::class, 'DistrictDelete'])->name('district.delete');

    Route::get('/state/view', [ShippingController::class, 'stateView'])->name('mng.state');
    Route::post('/state/store', [ShippingController::class, 'StateStore'])->name('state.store');
    Route::get('/state/edit/{id}', [ShippingController::class, 'StateEdit'])->name('state.edit');
    Route::post('/state/update', [ShippingController::class, 'StateUpdate'])->name('state.update');
    Route::get('/state/delete/{id}', [ShippingController::class, 'StateDelete'])->name('state.delete');

});

Route::prefix('orders')->group(function(){
    Route::get('/pending/orders', [OrderController::class, 'PendingOrders'])->name('pending-orders');
    Route::get('/pending/orders/details/{order_id}', [OrderController::class, 'PendingOrdersDetails'])->name('pending.order.details');

    Route::get('/confirmed/orders', [OrderController::class, 'ConfirmedOrders'])->name('confirmed-orders');

    Route::get('/processing/orders', [OrderController::class, 'ProcessingOrders'])->name('processing-orders');

    Route::get('/picked/orders', [OrderController::class, 'PickedOrders'])->name('picked-orders');

    Route::get('/shipped/orders', [OrderController::class, 'ShippedOrders'])->name('shipped-orders');

    Route::get('/delivered/orders', [OrderController::class, 'DeliveredOrders'])->name('delivered-orders');

    Route::get('/cancel/orders', [OrderController::class, 'CancelOrders'])->name('cancel-orders');

    Route::get('/pending/confirm/{order_id}', [OrderController::class, 'PendingToConfirm'])->name('pending-confirm');

    Route::get('/confirm/processing/{order_id}', [OrderController::class, 'ConfirmToProcessing'])->name('confirm.processing');

    Route::get('/processing/picked/{order_id}', [OrderController::class, 'ProcessingToPicked'])->name('processing.picked');

    Route::get('/picked/shipped/{order_id}', [OrderController::class, 'PickedToShipped'])->name('picked.shipped');

    Route::get('/shipped/delivered/{order_id}', [OrderController::class, 'ShippedToDelivered'])->name('shipped.delivered');

    Route::get('/invoice/download/{order_id}', [OrderController::class, 'AdminInvoiceDownload'])->name('invoice.download');
});

Route::prefix('reports')->group(function(){
    Route::get('/view', [ReportController::class, 'ViewReports'])->name('all-reports');

    Route::post('/search/by/date', [ReportController::class, 'ReportByDate'])->name('search-by-date');

    Route::post('/search/by/month', [ReportController::class, 'ReportByMonth'])->name('search-by-month');

    Route::post('/search/by/year', [ReportController::class, 'ReportByYear'])->name('search-by-year');
});

// Admin Get All User Routes 
Route::prefix('alluser')->group(function(){

    Route::get('/view', [AdminProfileController::class, 'AllUsers'])->name('all-users');
    
    
});

Route::prefix('blog')->group(function(){

    Route::get('/category', [BlogController::class, 'BlogCategory'])->name('blog.category');
    
    Route::post('/store', [BlogController::class, 'BlogCategoryStore'])->name('blogcategory.store');

    Route::get('/category/edit/{id}', [BlogController::class, 'BlogCategoryEdit'])->name('blog.category.edit');

    Route::post('/update', [BlogController::class, 'BlogCategoryUpdate'])->name('blogcategory.update');
    
    Route::get('/category/delete/{id}', [BlogController::class, 'BlogCategoryDelete'])->name('blog.category.delete');


    // Admin View Blog Post Routes 

    Route::get('/list/post', [BlogController::class, 'ListBlogPost'])->name('list.post');

    Route::get('/add/post', [BlogController::class, 'AddBlogPost'])->name('add.post');

    Route::post('/post/store', [BlogController::class, 'BlogPostStore'])->name('post-store');

    Route::get('/post/edit/{id}', [BlogController::class, 'BlogPostEdit'])->name('blog.post.edit');

    Route::post('/update', [BlogController::class, 'BlogPostUpdate'])->name('blog.post.update');
    
    Route::post('/update/image', [BlogController::class, 'BlogPostImageUpdate'])->name('blog.post.image.update');


    Route::get('/post/delete/{id}', [BlogController::class, 'BlogPostDelete'])->name('blog.post.delete');

    });

    // Admin Site Setting Routes 
    Route::prefix('setting')->group(function(){

    Route::get('/site', [SiteSettingController::class, 'SiteSetting'])->name('site.setting');
    Route::post('/site/update', [SiteSettingController::class, 'SiteSettingUpdate'])->name('update.sitesetting');

    Route::get('/seo', [SiteSettingController::class, 'SeoSetting'])->name('seo.setting'); 
    Route::post('/seo/update', [SiteSettingController::class, 'SeoSettingUpdate'])->name('update.seosetting');

    });

    // Admin Return Order Routes 
    Route::prefix('return')->group(function(){

    Route::get('/admin/request', [ReturnController::class, 'ReturnRequest'])->name('return.request');
    Route::get('/admin/return/approve/{order_id}', [ReturnController::class, 'ReturnRequestApprove'])->name('return.approve');

    Route::get('/admin/all/request', [ReturnController::class, 'ReturnAllRequest'])->name('all.request');
    });

    // Admin Manage Review Routes 
Route::prefix('review')->group(function(){

    Route::get('/pending', [ReviewController::class, 'PendingReview'])->name('pending.review');
    
    Route::get('/admin/approve/{id}', [ReviewController::class, 'ReviewApprove'])->name('review.approve');
    
    Route::get('/publish', [ReviewController::class, 'PublishReview'])->name('publish.review');

    Route::get('/delete/{id}', [ReviewController::class, 'DeleteReview'])->name('delete.review');
    });

    // Admin stock managment 
Route::prefix('stock')->group(function(){

    Route::get('/product', [ProductsController::class, 'ProductStock'])->name('product.stock');
    
    
    });

    // Admin User Role Routes 
Route::prefix('adminuserrole')->group(function(){

    Route::get('/all', [AdminUserController::class, 'AllAdminRole'])->name('all.admin.user');
    
    Route::get('/add', [AdminUserController::class, 'AddAdminRole'])->name('add.admin');

    Route::post('/store', [AdminUserController::class, 'StoreAdminRole'])->name('admin.user.store');
    
    Route::get('/edit/{id}', [AdminUserController::class, 'EditAdminRole'])->name('edit.admin.user');

    Route::post('/update', [AdminUserController::class, 'UpdateAdminRole'])->name('admin.user.update');
    Route::get('/delete/{id}', [AdminUserController::class, 'DeleteAdminRole'])->name('delete.admin.user');
    });

});




// User All Routes

Route::get('user/logout', [IndexController::class, 'UserLogout'])->name('user.logout');
Route::get('user/profile', [IndexController::class, 'UserProfile'])->name('user.profile');
Route::post('user/store', [IndexController::class, 'UserStore'])->name('user.profile.store');
Route::get('change/password', [IndexController::class, 'ChangePWD'])->name('change.password');
Route::post('user/update/password', [IndexController::class, 'UpdatePWD'])->name('user.password.update');


Route::middleware(['auth:sanctum,web', 'verified'])->get('/dashboard', function () {
    $id = Auth::user()->id;
    $user = User::find($id);
    return view('dashboard',compact('user'));
})->name('dashboard');


// Multi Languages routes //
Route::get('language/english', [LanguageController::class, 'English'])->name('english.language');
Route::get('language/arabic', [LanguageController::class, 'Arabic'])->name('arabic.language');

// frontend product details
Route::get('product/details/{id}/{slug}', [IndexController::class, 'frontProductDetails']);

// frontend product tags
Route::get('product/tag/{tag}', [IndexController::class, 'TagWiseProduct']);


//frontend subcategory wise data
Route::get('subcategory/product/{subcat_id}/{slug}', [IndexController::class, 'SubcatWiseProduct']);

//frontend subsubcategory wise data
Route::get('subsubcategory/product/{subsubcat_id}/{slug}', [IndexController::class, 'SubSubcatWiseProduct']);


//product view ajax
Route::get('product/view/model/{id}', [IndexController::class, 'productViewAjax']);


//product cart
Route::post('cart/data/store/{id}', [CartController::class, 'AddtoCart']);
Route::get('product/mini/cart/', [CartController::class, 'AddtominiCart']);
Route::get('minicart/product-remove/{rowId}', [CartController::class, 'miniCartRemove']);

Route::post('add-to-wishlist/{product_id}', [WishlistController::class, 'AddtoWishlist']);



/////////////////////  User Must Login  ////

Route::group(['prefix'=>'user','middleware' => ['user','auth'],'namespace'=>'User'],function(){
    //product wishlist
Route::get('wishlist/view/', [WishlistController::class, 'WishlistView'])->name('wishlist');
Route::get('wishlist-products/', [WishlistController::class, 'loadWishlistProducts']);
Route::get('wishlist/product-remove/{id}', [WishlistController::class, 'WishlistRemove']);

//payment
Route::post('/stripe/order', [StripeController::class, 'StripeOrder'])->name('stripe.order');

Route::post('/cash/order', [CashController::class, 'CashOrder'])->name('cash.order');
Route::get('/orders', [AllUserController::class, 'Orders'])->name('my.orders');

Route::get('/order_details/{order_id}', [AllUserController::class, 'OrderDetails']);
Route::get('/invoice_download/{order_id}', [AllUserController::class, 'InvoiceDownload']);
Route::post('/return/order/{order_id}', [AllUserController::class, 'ReturnOrder'])->name('return.order');

Route::get('/return/order/list', [AllUserController::class, 'ReturnOrderList'])->name('return.order.list');
Route::get('/cancel/orders', [AllUserController::class, 'CancelOrders'])->name('cancel.orders');
/// Order Traking Route 
Route::post('/order/tracking', [AllUserController::class, 'OrderTraking'])->name('order.tracking');    

});

Route::get('cart/view/', [CartPageController::class, 'CartView'])->name('mycart');
Route::get('cart-products/', [CartPageController::class, 'loadCartProducts']);
Route::get('cart/product-remove/{rowId}', [CartPageController::class, 'cartRemove']);

Route::get('/cart-increment/{rowId}', [CartPageController::class, 'cartIncrement']);
Route::get('/cart-decrement/{rowId}', [CartPageController::class, 'cartDecrement']);


//coupon
Route::post('/coupon-apply', [CartController::class, 'couponApply']);
Route::get('/coupon-calculation', [CartController::class, 'couponCalculation']);
Route::get('/coupon-remove', [CartController::class, 'couponRemove']);

//checkout
Route::get('/checkout', [CartController::class, 'Checkout'])->name('checkout');

Route::get('/district-get/ajax/{division_id}', [CheckController::class, 'DistrictGet']);
Route::get('/state-get/ajax/{district_id}', [CheckController::class, 'StateGet']);

Route::post('/checkout/store', [CheckController::class, 'CheckoutStore'])->name('checkout.store');


//  Frontend Blog Show Routes 

Route::get('/blog', [HomeBlogController::class, 'AddBlogPost'])->name('home.blog');
Route::get('/post/details/{id}', [HomeBlogController::class, 'DetailsBlogPost'])->name('post.details');
Route::get('/blog/category/post/{category_id}', [HomeBlogController::class, 'HomeBlogCatPost']);


/// Frontend Product Review Routes

Route::post('/review/store', [ReviewController::class, 'ReviewStore'])->name('review.store');

/// Product Search Route 
Route::post('/search', [IndexController::class, 'ProductSearch'])->name('product.search');

// Advance Search Routes 
Route::post('search-product', [IndexController::class, 'SearchProduct']);

// Shop Page Route 
Route::get('/shop', [ShopController::class, 'ShopPage'])->name('shop.page');

Route::post('/shop/filter', [ShopController::class, 'ShopFilter'])->name('shop.filter');
