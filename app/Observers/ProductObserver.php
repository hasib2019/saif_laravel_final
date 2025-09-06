<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\CacheService;

class ProductObserver
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $this->clearRelatedCache($product);
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        $this->clearRelatedCache($product);
        
        // If the product's category changed, clear category cache too
        if ($product->isDirty('category_id')) {
            $this->cacheService->clearModelCache('category');
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        $this->clearRelatedCache($product);
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        $this->clearRelatedCache($product);
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        $this->clearRelatedCache($product);
    }

    /**
     * Clear cache related to the product
     */
    private function clearRelatedCache(Product $product): void
    {
        $this->cacheService->clearModelCache('product', $product->id);
        
        // Clear category cache if this affects category relationships
        if ($product->category_id) {
            $this->cacheService->clearModelCache('category', $product->category_id);
        }
    }
}