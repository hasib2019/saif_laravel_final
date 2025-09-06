<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Product;
use App\Models\Page;

class CacheService
{
    // Cache TTL constants (in seconds)
    const CACHE_TTL_SHORT = 300;    // 5 minutes
    const CACHE_TTL_MEDIUM = 1800;  // 30 minutes
    const CACHE_TTL_LONG = 3600;    // 1 hour
    const CACHE_TTL_VERY_LONG = 86400; // 24 hours

    // Cache key prefixes
    const PREFIX_CATEGORIES = 'categories';
    const PREFIX_PRODUCTS = 'products';
    const PREFIX_PAGES = 'pages';
    const PREFIX_SETTINGS = 'settings';
    const PREFIX_MENU = 'menu';
    const PREFIX_STATS = 'stats';

    /**
     * Get all active categories with caching
     */
    public function getActiveCategories(): Collection
    {
        return Cache::remember(
            self::PREFIX_CATEGORIES . ':active',
            self::CACHE_TTL_LONG,
            function () {
                return Category::where('is_active', true)
                    ->orderBy('sort_order')
                    ->orderBy('name')
                    ->get();
            }
        );
    }

    /**
     * Get category with products
     */
    public function getCategoryWithProducts(int $categoryId): ?Category
    {
        return Cache::remember(
            self::PREFIX_CATEGORIES . ":with_products:{$categoryId}",
            self::CACHE_TTL_MEDIUM,
            function () use ($categoryId) {
                return Category::with(['products' => function ($query) {
                    $query->where('is_active', true)
                        ->orderBy('sort_order')
                        ->orderBy('name');
                }])
                ->where('is_active', true)
                ->find($categoryId);
            }
        );
    }

    /**
     * Get featured products
     */
    public function getFeaturedProducts(int $limit = 8): Collection
    {
        return Cache::remember(
            self::PREFIX_PRODUCTS . ":featured:{$limit}",
            self::CACHE_TTL_MEDIUM,
            function () use ($limit) {
                return Product::where('is_active', true)
                    ->where('featured', true)
                    ->with('category')
                    ->orderBy('created_at', 'desc')
                    ->limit($limit)
                    ->get();
            }
        );
    }

    /**
     * Get latest products
     */
    public function getLatestProducts(int $limit = 12): Collection
    {
        return Cache::remember(
            self::PREFIX_PRODUCTS . ":latest:{$limit}",
            self::CACHE_TTL_SHORT,
            function () use ($limit) {
                return Product::where('is_active', true)
                    ->with('category')
                    ->orderBy('created_at', 'desc')
                    ->limit($limit)
                    ->get();
            }
        );
    }

    /**
     * Get product by slug with related data
     */
    public function getProductBySlug(string $slug): ?Product
    {
        return Cache::remember(
            self::PREFIX_PRODUCTS . ":slug:{$slug}",
            self::CACHE_TTL_LONG,
            function () use ($slug) {
                return Product::where('slug', $slug)
                    ->where('is_active', true)
                    ->with(['category'])
                    ->first();
            }
        );
    }

    /**
     * Get related products
     */
    public function getRelatedProducts(int $productId, int $categoryId, int $limit = 4): Collection
    {
        return Cache::remember(
            self::PREFIX_PRODUCTS . ":related:{$productId}:{$categoryId}:{$limit}",
            self::CACHE_TTL_MEDIUM,
            function () use ($productId, $categoryId, $limit) {
                return Product::where('category_id', $categoryId)
                    ->where('id', '!=', $productId)
                    ->where('is_active', true)
                    ->with('category')
                    ->inRandomOrder()
                    ->limit($limit)
                    ->get();
            }
        );
    }

    /**
     * Get page by slug
     */
    public function getPageBySlug(string $slug): ?Page
    {
        return Cache::remember(
            self::PREFIX_PAGES . ":slug:{$slug}",
            self::CACHE_TTL_VERY_LONG,
            function () use ($slug) {
                return Page::where('slug', $slug)
                    ->where('is_active', true)
                    ->first();
            }
        );
    }

    /**
     * Get navigation menu items
     */
    public function getNavigationMenu(): Collection
    {
        return Cache::remember(
            self::PREFIX_MENU . ':navigation',
            self::CACHE_TTL_VERY_LONG,
            function () {
                return Category::where('is_active', true)
                    ->orderBy('sort_order')
                    ->orderBy('name')
                    ->get(['id', 'name', 'slug', 'sort_order']);
            }
        );
    }

    /**
     * Get site statistics
     */
    public function getSiteStats(): array
    {
        return Cache::remember(
            self::PREFIX_STATS . ':site',
            self::CACHE_TTL_LONG,
            function () {
                return [
                    'total_products' => Product::where('is_active', true)->count(),
                    'total_categories' => Category::where('is_active', true)->count(),
                    'featured_products' => Product::where('is_active', true)->where('featured', true)->count(),
                    'total_pages' => Page::where('is_active', true)->count(),
                ];
            }
        );
    }

    /**
     * Get application settings
     */
    public function getSettings(): array
    {
        return Cache::remember(
            self::PREFIX_SETTINGS . ':app',
            self::CACHE_TTL_VERY_LONG,
            function () {
                // This would typically come from a settings table
                // For now, return default settings
                return [
                    'site_name' => config('app.name'),
                    'site_description' => 'Professional business website',
                    'contact_email' => 'info@example.com',
                    'contact_phone' => '+1234567890',
                    'social_facebook' => '',
                    'social_twitter' => '',
                    'social_instagram' => '',
                    'social_linkedin' => '',
                    'products_per_page' => 12,
                    'enable_search' => true,
                    'enable_newsletter' => true,
                ];
            }
        );
    }

    /**
     * Clear cache for a specific model
     */
    public function clearModelCache(string $modelType, int $id = null): void
    {
        $patterns = [];
        
        switch ($modelType) {
            case 'category':
                $patterns = [
                    self::PREFIX_CATEGORIES . ':*',
                    self::PREFIX_MENU . ':*',
                    self::PREFIX_STATS . ':*'
                ];
                if ($id) {
                    $patterns[] = self::PREFIX_CATEGORIES . ":with_products:{$id}";
                }
                break;
                
            case 'product':
                $patterns = [
                    self::PREFIX_PRODUCTS . ':*',
                    self::PREFIX_STATS . ':*'
                ];
                break;
                
            case 'page':
                $patterns = [
                    self::PREFIX_PAGES . ':*',
                    self::PREFIX_STATS . ':*'
                ];
                break;
                
            case 'settings':
                $patterns = [self::PREFIX_SETTINGS . ':*'];
                break;
        }

        foreach ($patterns as $pattern) {
            $this->clearCacheByPattern($pattern);
        }
    }

    /**
     * Clear cache by pattern
     */
    private function clearCacheByPattern(string $pattern): void
    {
        try {
            $cacheStore = Cache::getStore();
            
            if ($cacheStore instanceof \Illuminate\Cache\RedisStore) {
                // Use Redis pattern matching
                $redis = $cacheStore->getRedis();
                $prefix = $cacheStore->getPrefix();
                $keys = $redis->keys($prefix . $pattern);
                
                if (!empty($keys)) {
                    $redis->del($keys);
                }
            } else {
                // For database cache, we need to clear specific keys or flush all
                // Since database cache doesn't support pattern matching, we'll clear all cache
                \Log::info('Pattern-based cache clearing not supported for database driver, clearing all cache');
                Cache::flush();
            }
        } catch (\Exception $e) {
            \Log::warning('Cache clear failed: ' . $e->getMessage());
            Cache::flush();
        }
    }

    /**
     * Clear all application cache
     */
    public function clearAllCache(): void
    {
        Cache::flush();
    }

    /**
     * Warm up cache with frequently accessed data
     */
    public function warmUpCache(): void
    {
        // Warm up categories
        $this->getActiveCategories();
        $this->getNavigationMenu();
        
        // Warm up products
        $this->getFeaturedProducts();
        $this->getLatestProducts();
        
        // Warm up settings and stats
        $this->getSettings();
        $this->getSiteStats();
        
        \Log::info('Cache warmed up successfully');
    }

    /**
     * Get cache statistics
     */
    public function getCacheStats(): array
    {
        try {
            $cacheStore = Cache::getStore();
            
            if ($cacheStore instanceof \Illuminate\Cache\RedisStore) {
                $redis = $cacheStore->getRedis();
                $info = $redis->info();
                
                return [
                    'driver' => 'redis',
                    'total_keys' => $redis->dbSize(),
                    'memory_usage' => $info['used_memory_human'] ?? 'N/A',
                    'connected_clients' => $info['connected_clients'] ?? 'N/A',
                    'uptime' => $info['uptime_in_seconds'] ?? 'N/A',
                ];
            } else {
                // For database or other cache drivers
                return [
                    'driver' => config('cache.default'),
                    'status' => 'active',
                    'message' => 'Cache statistics not available for this driver',
                ];
            }
        } catch (\Exception $e) {
            return [
                'error' => 'Unable to retrieve cache statistics: ' . $e->getMessage()
            ];
        }
    }
}