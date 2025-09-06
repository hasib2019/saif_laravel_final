<?php

namespace App\Observers;

use App\Models\Category;
use App\Services\CacheService;

class CategoryObserver
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $this->clearRelatedCache($category);
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $this->clearRelatedCache($category);
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        $this->clearRelatedCache($category);
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        $this->clearRelatedCache($category);
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        $this->clearRelatedCache($category);
    }

    /**
     * Clear cache related to the category
     */
    private function clearRelatedCache(Category $category): void
    {
        $this->cacheService->clearModelCache('category', $category->id);
        
        // Also clear product cache if category has products
        if ($category->products()->exists()) {
            $this->cacheService->clearModelCache('product');
        }
    }
}