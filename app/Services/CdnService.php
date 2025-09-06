<?php

namespace App\Services;

class CdnService
{
    /**
     * Get the CDN URL for an asset
     *
     * @param string $path
     * @return string
     */
    public static function asset(string $path): string
    {
        // Remove leading slash if present
        $path = ltrim($path, '/');
        
        // If CDN is enabled and configured
        if (config('cdn.enabled') && !empty(config('cdn.url'))) {
            return rtrim(config('cdn.url'), '/') . '/' . $path;
        }
        
        // If asset URL is configured (for non-CDN scenarios)
        if (!empty(config('cdn.asset_url'))) {
            return rtrim(config('cdn.asset_url'), '/') . '/' . $path;
        }
        
        // Fallback to Laravel's asset helper
        return asset($path);
    }
    
    /**
     * Get the CDN URL for a mix asset
     *
     * @param string $path
     * @return string
     */
    public static function mix(string $path): string
    {
        // Get the versioned path from mix
        $versionedPath = mix($path);
        
        // If CDN is enabled, replace the base URL
        if (config('cdn.enabled') && !empty(config('cdn.url'))) {
            $baseUrl = config('app.url');
            $cdnUrl = rtrim(config('cdn.url'), '/');
            return str_replace($baseUrl, $cdnUrl, $versionedPath);
        }
        
        return $versionedPath;
    }
    
    /**
     * Get the CDN URL for an image
     *
     * @param string $path
     * @param string $default
     * @return string
     */
    public static function image(string $path, string $default = ''): string
    {
        if (empty($path)) {
            return $default ? self::asset($default) : '';
        }
        
        // If path already contains http/https, return as is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        
        return self::asset($path);
    }
    
    /**
     * Check if CDN is enabled
     *
     * @return bool
     */
    public static function isEnabled(): bool
    {
        return config('cdn.enabled', false) && !empty(config('cdn.url'));
    }
    
    /**
     * Get CDN configuration info
     *
     * @return array
     */
    public static function getConfig(): array
    {
        return [
            'enabled' => self::isEnabled(),
            'cdn_url' => config('cdn.url'),
            'asset_url' => config('cdn.asset_url'),
            'domains' => config('cdn.domains', []),
            'extensions' => config('cdn.extensions', []),
        ];
    }
}