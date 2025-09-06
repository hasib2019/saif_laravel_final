<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Product;
use App\Models\Page;
use App\Models\WebsiteSettings;
use App\Observers\CategoryObserver;
use App\Observers\ProductObserver;
use App\Observers\PageObserver;
use App\Services\CacheService;
use App\Services\CdnService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register CacheService as singleton
        $this->app->singleton(CacheService::class, function ($app) {
            return new CacheService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers
        Category::observe(CategoryObserver::class);
        Product::observe(ProductObserver::class);
        Page::observe(PageObserver::class);
        
        // Register CDN Blade directives
        Blade::directive('cdnAsset', function ($expression) {
            return "<?php echo App\\Services\\CdnService::asset($expression); ?>";
        });
        
        Blade::directive('cdnMix', function ($expression) {
            return "<?php echo App\\Services\\CdnService::mix($expression); ?>";
        });
        
        Blade::directive('cdnImage', function ($expression) {
            return "<?php echo App\\Services\\CdnService::image($expression); ?>";
        });
        
        // Share website settings with all views
        View::composer('*', function ($view) {
            $view->with('globalSettings', WebsiteSettings::getSettings());
        });
    }
}
