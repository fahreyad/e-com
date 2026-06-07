<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\BusinessSettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeliveryChargeController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\OutletSliderController;
use App\Http\Controllers\Admin\PackageProductController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\VariationController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->middleware('auth:admin');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('auth:admin')
        ->name('dashboard');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->middleware('guest:admin')
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest:admin');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->middleware('guest:admin')
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest:admin')
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->middleware('guest:admin')
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest:admin')
        ->name('password.update');

    Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->middleware('auth:admin')
        ->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['auth:admin', 'signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth:admin', 'throttle:6,1'])
        ->name('verification.send');

    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->middleware('auth:admin')
        ->name('password.confirm');

    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
        ->middleware('auth:admin');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth:admin')
        ->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::resource('password-update', \App\Http\Controllers\Admin\PasswordUpdateController::class)
            ->only(['create', 'store']);
        Route::resource('profile-update', \App\Http\Controllers\Admin\ProfileUpdateController::class)
            ->only(['create', 'store']);
        Route::resource('user', \App\Http\Controllers\Admin\UserController::class)->middleware('role:admin');

        Route::get('user/portal/{user}', [\App\Http\Controllers\Admin\UserController::class, 'portal'])->middleware('role:admin')->name('user.portal');

        /* Home Page Route  */
        Route::prefix('website')->group(function () {
            Route::resource('notice', NoticeController::class);
            Route::resource('slider', SliderController::class);
            Route::get('banner', [BusinessSettingController::class, 'banner'])->name('banner.index');
            Route::resource('outlet-slider', OutletSliderController::class);
            Route::get('best-deals', [BusinessSettingController::class, 'bestDeals'])->name('best-deals.index');
            // Route::resource('team', TeamController::class);
            // Route::resource('gallery', GalleryController::class)->only('index', 'store', 'edit', 'update', 'destroy');
        });

        Route::resource('branch', BranchController::class);

        /* Product Related Route  */
        Route::resource('package-product', PackageProductController::class);
        Route::resource('product', ProductController::class);
        Route::resource('variation', VariationController::class)->only('index', 'store', 'edit', 'update', 'destroy');
        Route::resource('categories', CategoryController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');


        /* Orders Route */
        Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)->only('index', 'show', 'update');

        Route::get('orders/{branch_name}/{branch_id}', [App\Http\Controllers\Admin\OrderController::class, 'orderBranch'])->name('order.branch');
        Route::get('/orders/{order_id}/invoice', [App\Http\Controllers\Admin\OrderController::class, 'downloadInvoice'])->name('orders.invoice');

        Route::resource('corporate-orders', App\Http\Controllers\Admin\CorporateOrderController::class)->only('index', 'show', 'update');
        Route::get('corporate-orders/{branch_name}/{branch_id}', [App\Http\Controllers\Admin\CorporateOrderController::class, 'corporateOrdersBranch'])->name('corporate-orders.branch');

        Route::get('/corporate-orders/{order_id}/invoice', [App\Http\Controllers\Admin\CorporateOrderController::class, 'downloadInvoice'])->name('corporate-orders.invoice');

        Route::resource('delivery-charge', DeliveryChargeController::class);
        Route::get('generale-setting', [BusinessSettingController::class, 'generaleSetting'])->name('generale-setting.index');
        Route::get('social-links', [BusinessSettingController::class, 'socialLinks'])->name('social-links.index');
        Route::get('pixel-setup', [BusinessSettingController::class, 'pixelSetup'])->name('pixel-setup.index');

        Route::post('business-setting', [BusinessSettingController::class, 'businessSettingUpdate'])->name('business-setting.update');
    });
});
