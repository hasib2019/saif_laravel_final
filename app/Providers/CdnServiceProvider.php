<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

class CdnServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Set asset URL if CDN is enabled
        if (config('cdn.enabled') && !empty(config('cdn.url'))) {
            Config::set('app.asset_url', config('cdn.url'));
        }

        // Force asset URL for mix() and asset() helpers
        if (!empty(config('cdn.asset_url'))) {
            URL::forceRootUrl(config('cdn.asset_url'));
        }
    }
}