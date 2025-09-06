<?php

namespace App\Observers;

use App\Models\Page;
use App\Services\CacheService;

class PageObserver
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Handle the Page "created" event.
     */
    public function created(Page $page): void
    {
        $this->clearRelatedCache($page);
    }

    /**
     * Handle the Page "updated" event.
     */
    public function updated(Page $page): void
    {
        $this->clearRelatedCache($page);
    }

    /**
     * Handle the Page "deleted" event.
     */
    public function deleted(Page $page): void
    {
        $this->clearRelatedCache($page);
    }

    /**
     * Handle the Page "restored" event.
     */
    public function restored(Page $page): void
    {
        $this->clearRelatedCache($page);
    }

    /**
     * Handle the Page "force deleted" event.
     */
    public function forceDeleted(Page $page): void
    {
        $this->clearRelatedCache($page);
    }

    /**
     * Clear cache related to the page
     */
    private function clearRelatedCache(Page $page): void
    {
        $this->cacheService->clearModelCache('page', $page->id);
    }
}