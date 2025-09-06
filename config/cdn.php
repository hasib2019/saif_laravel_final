<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CDN Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration options for Content Delivery Network
    | (CDN) integration. When enabled, static assets will be served from the
    | configured CDN URL instead of the local application URL.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | CDN Enabled
    |--------------------------------------------------------------------------
    |
    | This option determines whether CDN integration is enabled. When set to
    | true, all asset URLs will be prefixed with the CDN URL.
    |
    */

    'enabled' => env('CDN_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | CDN URL
    |--------------------------------------------------------------------------
    |
    | This is the base URL of your CDN. All asset URLs will be prefixed with
    | this URL when CDN is enabled. Make sure to include the protocol (http/https)
    | but do not include a trailing slash.
    |
    | Example: https://cdn.example.com
    |
    */

    'url' => env('CDN_URL'),

    /*
    |--------------------------------------------------------------------------
    | Asset URL Override
    |--------------------------------------------------------------------------
    |
    | This option allows you to override the asset URL without enabling full
    | CDN functionality. Useful for serving assets from a different domain
    | or subdomain.
    |
    */

    'asset_url' => env('ASSET_URL'),

    /*
    |--------------------------------------------------------------------------
    | CDN Domains
    |--------------------------------------------------------------------------
    |
    | You can specify multiple CDN domains for load balancing. Assets will be
    | distributed across these domains using a hash-based approach.
    |
    */

    'domains' => [
        // env('CDN_URL'),
        // env('CDN_URL_2'),
        // env('CDN_URL_3'),
    ],

    /*
    |--------------------------------------------------------------------------
    | File Extensions
    |--------------------------------------------------------------------------
    |
    | Specify which file extensions should be served via CDN. Leave empty
    | to serve all assets via CDN.
    |
    */

    'extensions' => [
        'css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp',
        'woff', 'woff2', 'ttf', 'eot', 'ico', 'pdf', 'zip',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Control
    |--------------------------------------------------------------------------
    |
    | Configure cache control headers for CDN assets. These settings help
    | optimize caching behavior.
    |
    */

    'cache' => [
        'max_age' => env('CDN_CACHE_MAX_AGE', 31536000), // 1 year
        'public' => env('CDN_CACHE_PUBLIC', true),
    ],

];