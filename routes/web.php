<?php

use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\FrontEnd\CartController;
use App\Http\Controllers\FrontEnd\CheckOutController;
use App\Http\Controllers\FrontEnd\CorporateOrderController;
use App\Http\Controllers\FrontEnd\HomeController;
use App\Http\Controllers\FrontEnd\ProductController;
use App\Http\Controllers\FrontEnd\ViewCartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/home', fn() => redirect('/'));


Route::post('/branch-select', [BranchController::class, 'branchSelect'])->name('branch-select');
Route::get('/search', [HomeController::class, 'search'])->name('search.index');

Route::resource('/category', \App\Http\Controllers\FrontEnd\CategoryController::class)->only('show');
Route::resource('/products', ProductController::class)->only('index', 'show');

// Cart Route
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

Route::post('/product-remove-from-cart/{id}', [CartController::class, 'productRemoveFromCart'])->name('cart.product-remove');
Route::get('/product-remove-from-cart/{id}', [CartController::class, 'productDeleteFromCart'])->name('cart.product-delete');
Route::get('/clear-cart', [CartController::class, 'clearCart'])->name('clear-cart');

Route::resource('/view-cart', ViewCartController::class)->only('index');
Route::resource('/checkout', CheckOutController::class)->only('index', 'store');
Route::get('/thank-you', [CheckOutController::class, "thankYouPage"])->name('thankyou.index');

// Corporate Orders
Route::resource('/corporate-order', CorporateOrderController::class)->only('index', 'store');
Route::get('/corporate-order-next-page', [CorporateOrderController::class, 'corporateNextPage'])->name('corporate-next-page');
Route::get('/corporate-order-details', [CorporateOrderController::class, 'corporateOrderDetails'])->name('corporate-order-details.store');
Route::post('/corporate-order-add-to-cart', [CorporateOrderController::class, 'corporateOrderAddToCart'])->name('corporate-order-add-to-cart.store');
Route::post('/corporate-order-remove-product/{id}', [CorporateOrderController::class, 'corporateOrderRemoveProduct'])->name('corporate-cart.remove-product');

Route::get('/corporate-thank-you', [CorporateOrderController::class, "corporateThankYouPage"])->name('corporate-thankyou.index');



Route::resource('password-update', \App\Http\Controllers\PasswordUpdateController::class)
    ->only(['create', 'store']);
Route::resource('profile-update', \App\Http\Controllers\ProfileUpdateController::class)
    ->only(['create', 'store']);

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', \App\Http\Controllers\DashboardController::class)->name('dashboard');

    // Orders Route
    Route::resource('/my-orders',  OrderController::class)->only('index', 'show');
    Route::get('/new-orders',  [OrderController::class, 'newOrders'])->name('new-orders.index');
    Route::get('/processing-orders',  [OrderController::class, 'processingOrders'])->name('processing-orders.index');
    Route::get('/delivered-orders',  [OrderController::class, 'deliveredOrders'])->name('delivered-orders.index');
    Route::get('/cancelled-orders',  [OrderController::class, 'cancelledOrders'])->name('cancelled-orders.index');

    Route::get('/orders/{order_id}/invoice', [App\Http\Controllers\Admin\OrderController::class, 'downloadInvoice'])->name('orders.invoice');

    Route::resource('password-update', \App\Http\Controllers\PasswordUpdateController::class)
        ->only(['create', 'store']);
    Route::resource('profile-update', \App\Http\Controllers\ProfileUpdateController::class)
        ->only(['create', 'store']);


    // Route::prefix('affiliate')->name('affiliate.')->group(function () {
    //     Route::get('list', \App\Http\Controllers\Affiliate\ReferralListController::class)->name('list.index');
    //     Route::get('tree', \App\Http\Controllers\Affiliate\ReferralTreeController::class)->name('tree.index');
    // });
});

Route::get('portal/{user}', \App\Http\Controllers\PortalController::class)->name('portal');


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
