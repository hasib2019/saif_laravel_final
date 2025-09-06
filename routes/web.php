<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;
use App\Models\Page;
use App\Models\WebsiteSettings;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ContactController;
use App\Services\CacheService;

// Home page
Route::get('/', function (CacheService $cacheService) {
    $categories = $cacheService->getActiveCategories();
    $products = $cacheService->getFeaturedProducts(8);
    $settings = WebsiteSettings::getSettings();
    
    return view('home', compact('categories', 'products', 'settings'));
})->name('home');

// Catalogs page
Route::get('/catalogs', function (CacheService $cacheService) {
    $categories = $cacheService->getActiveCategories();
    
    // For products, we still need to handle pagination and filtering
    $products = Product::with(['category:id,name,slug'])
        ->where('is_active', true)
        ->when(request('category'), function($query) {
            $category = Category::where('slug', request('category'))
                ->select('id')
                ->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        })
        ->select('id', 'name', 'slug', 'price', 'image', 'category_id', 'stock_quantity', 'description')
        ->paginate(12);
    
    return view('catalogs', compact('categories', 'products'));
})->name('catalogs');

// Custom pages
Route::get('/page/{slug}', function ($slug, CacheService $cacheService) {
    $page = $cacheService->getPageBySlug($slug);
    
    if (!$page) {
        abort(404);
    }
    
    return view('page', compact('page'));
})->name('page.show');

// About Us page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Contact Us routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

// Language switching routes
Route::get('/language/{locale}', [LanguageController::class, 'switchLanguage'])->name('language.switch');
