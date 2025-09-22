<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;
use App\Models\Page;
use App\Models\WebsiteSettings;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SupplierController;
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
        ->select('id', 'name', 'slug', 'price', 'sale_price', 'image', 'category_id', 'stock_quantity', 'description', 'short_description', 'sku', 'featured')
        ->paginate(12);
    
    return view('catalogs', compact('categories', 'products'));
})->name('catalogs');

// Product detail page
Route::get('/product/{slug}', function ($slug, CacheService $cacheService) {
    $product = Product::with(['category:id,name,slug'])
        ->where('slug', $slug)
        ->where('is_active', true)
        ->first();
    
    if (!$product) {
        abort(404);
    }
    
    // Get related products from the same category
    $relatedProducts = Product::with(['category:id,name,slug'])
        ->where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->where('is_active', true)
        ->select('id', 'name', 'slug', 'price', 'sale_price', 'image', 'category_id', 'short_description')
        ->limit(4)
        ->get();
    
    return view('product-detail', compact('product', 'relatedProducts'));
})->name('product.show');

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
    $aboutSettings = \App\Models\AboutSetting::getSettings();
    $teamMembers = \App\Models\TeamMember::active()->ordered()->get();
    return view('about', compact('aboutSettings', 'teamMembers'));
})->name('about');

// Gallery routes
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery/{id}', [GalleryController::class, 'show'])->name('gallery.show');

// Contact Us routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

// Language switching routes
Route::get('/language/{locale}', [LanguageController::class, 'switchLanguage'])->name('language.switch');

// Order routes
Route::get('/order/{productSlug}', [OrderController::class, 'create'])->name('order.create');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order-success/{orderNumber}', [OrderController::class, 'success'])->name('order.success');
Route::get('/order-details/{orderNumber}', [OrderController::class, 'show'])->name('order.show');

// News & Media routes
Route::prefix('news')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/search', [NewsController::class, 'search'])->name('search');
    Route::get('/featured', [NewsController::class, 'featured'])->name('featured');
    Route::get('/load-more', [NewsController::class, 'loadMore'])->name('load-more');
    Route::get('/archive/{year?}/{month?}', [NewsController::class, 'archive'])->name('archive');
    Route::get('/rss', [NewsController::class, 'rss'])->name('rss');
    Route::get('/sitemap', [NewsController::class, 'sitemap'])->name('sitemap');
    Route::get('/{slug}', [NewsController::class, 'show'])->name('show');
});

// Suppliers routes
Route::prefix('suppliers')->name('suppliers.')->group(function () {
    Route::get('/', [SupplierController::class, 'index'])->name('index');
    Route::get('/search', [SupplierController::class, 'search'])->name('search');
    Route::get('/load-more', [SupplierController::class, 'loadMore'])->name('load-more');
    Route::get('/{slug}', [SupplierController::class, 'show'])->name('show');
});
