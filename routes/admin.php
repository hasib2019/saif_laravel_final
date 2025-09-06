<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\WebsiteSetupController;
use App\Http\Controllers\Admin\ContactController;

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes (not authenticated)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    // Authenticated admin routes
    Route::middleware(['admin.auth', 'image.optimize'])->group(function () {
        Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        
        // Categories Management
        Route::resource('categories', CategoryController::class);
        
        // Products Management
        Route::resource('products', ProductController::class);
        
        // Pages Management
        Route::resource('pages', PageController::class);
        
        // Contact Messages Management
        Route::prefix('contacts')->name('contacts.')->group(function () {
            Route::get('/', [ContactController::class, 'index'])->name('index');
            Route::get('/{contact}', [ContactController::class, 'show'])->name('show');
            Route::patch('/{contact}/mark-read', [ContactController::class, 'markAsRead'])->name('mark-read');
            Route::patch('/{contact}/mark-unread', [ContactController::class, 'markAsUnread'])->name('mark-unread');
            Route::delete('/{contact}', [ContactController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-action', [ContactController::class, 'bulkAction'])->name('bulk-action');
        });
        
        // Website Setup Management
        Route::prefix('website-setup')->name('website-setup.')->group(function () {
            Route::get('/', [WebsiteSetupController::class, 'index'])->name('index');
            Route::get('/video-section', [WebsiteSetupController::class, 'videoSection'])->name('video-section');
            Route::put('/video-section', [WebsiteSetupController::class, 'updateVideoSection'])->name('update-video-section');
            Route::get('/company-about', [WebsiteSetupController::class, 'companyAbout'])->name('company-about');
            Route::put('/company-about', [WebsiteSetupController::class, 'updateCompanyAbout'])->name('update-company-about');
            Route::get('/site-identity', [WebsiteSetupController::class, 'siteIdentity'])->name('site-identity');
            Route::put('/site-identity', [WebsiteSetupController::class, 'updateSiteIdentity'])->name('update-site-identity');
            Route::get('/footer-settings', [WebsiteSetupController::class, 'footerSettings'])->name('footer-settings');
            Route::put('/footer-settings', [WebsiteSetupController::class, 'updateFooterSettings'])->name('update-footer-settings');
        });
    });
});