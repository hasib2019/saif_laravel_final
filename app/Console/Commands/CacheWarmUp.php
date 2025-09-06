<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CacheService;

class CacheWarmUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:warm-up {--clear : Clear cache before warming up}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warm up application cache with frequently accessed data';

    /**
     * Execute the console command.
     */
    public function handle(CacheService $cacheService): int
    {
        if ($this->option('clear')) {
            $this->info('Clearing existing cache...');
            $cacheService->clearAllCache();
        }

        $this->info('Warming up cache...');
        
        try {
            $cacheService->warmUpCache();
            $this->info('Cache warmed up successfully!');
            
            // Display cache statistics
            $stats = $cacheService->getCacheStats();
            if (!isset($stats['error'])) {
                if ($stats['driver'] === 'redis') {
                    $this->table(
                        ['Metric', 'Value'],
                        [
                            ['Driver', $stats['driver']],
                            ['Total Keys', $stats['total_keys']],
                            ['Memory Usage', $stats['memory_usage']],
                            ['Connected Clients', $stats['connected_clients']],
                            ['Uptime', $stats['uptime'] . ' seconds'],
                        ]
                    );
                } else {
                    $this->table(
                        ['Metric', 'Value'],
                        [
                            ['Driver', $stats['driver']],
                            ['Status', $stats['status']],
                            ['Message', $stats['message']],
                        ]
                    );
                }
            } else {
                $this->warn('Cache statistics: ' . $stats['error']);
            }
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to warm up cache: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}