<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CacheService;

class CacheClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear-model {model? : The model type to clear (category, product, page, settings)} {--all : Clear all cache}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear cache for specific models or all cache';

    /**
     * Execute the console command.
     */
    public function handle(CacheService $cacheService): int
    {
        if ($this->option('all')) {
            $this->info('Clearing all cache...');
            $cacheService->clearAllCache();
            $this->info('All cache cleared successfully!');
            return Command::SUCCESS;
        }

        $model = $this->argument('model');
        
        if (!$model) {
            $model = $this->choice(
                'Which model cache would you like to clear?',
                ['category', 'product', 'page', 'settings', 'all'],
                0
            );
        }

        if ($model === 'all') {
            $this->info('Clearing all cache...');
            $cacheService->clearAllCache();
            $this->info('All cache cleared successfully!');
        } else {
            $validModels = ['category', 'product', 'page', 'settings'];
            
            if (!in_array($model, $validModels)) {
                $this->error('Invalid model type. Valid options: ' . implode(', ', $validModels));
                return Command::FAILURE;
            }

            $this->info("Clearing {$model} cache...");
            $cacheService->clearModelCache($model);
            $this->info(ucfirst($model) . ' cache cleared successfully!');
        }

        return Command::SUCCESS;
    }
}