<?php

namespace Belt\Core\Commands;

use Belt;
use Belt\Core\Services\PublishService;
use Illuminate\Console\Command;

/**
 * Class PublishCommand
 * @package Belt\Core\Commands
 */
class PublishCommand extends Command
{

    use Belt\Core\Behaviors\HasService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belt-core:publish {action=publish} {--include=} {--exclude=} {--force} {--config} {--prune}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'publish assets for belt core';

    /**
     * @var PublishService
     */
    protected $serviceClass = PublishService::class;

    /**
     * @var array
     */
    protected $dirs = [
        'vendor/larabelt/core/config' => 'config/belt',
        'vendor/larabelt/core/database/factories' => 'database/factories',
        'vendor/larabelt/core/database/migrations' => 'database/migrations',
        'vendor/larabelt/core/database/seeds' => 'database/seeds',
        'vendor/larabelt/core/database/testing' => 'database/testing',
        'vendor/larabelt/core/docs' => 'resources/docs/raw',
    ];

    /**
     * @var array
     */
    protected $files = [];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $action = $this->argument('action');

        $service = $this->service();

        if ($action == 'publish') {
            $this->publish($service);
        }

        if ($action == 'create-history-from-table') {
            $service->createHistoryFromTable();
        }
    }

    /**
     * Publish contents
     *
     * @param $service
     */
    public function publish($service)
    {
        $service->publish();

        if ($service->created) {
            $this->info("\nThe following files were added:\n");
            foreach ($service->created as $file) {
                $this->info($file);
            }
        }

        if ($service->modified) {
            $this->info("\nThe following files were overwritten:\n");
            foreach ($service->modified as $file) {
                $this->info($file);
            }
        }

        if ($service->ignored) {
            $this->warn("\nThe following files were ignored though source files have changed:\n");
            foreach ($service->ignored as $file) {
                $this->warn($file);
            }
        }
    }

    /**
     * @return PublishService
     */
    public function service()
    {
        $this->service = $this->service ?: new PublishService([
            'key' => belt()->guessPackage(get_class($this)),
            'dirs' => $this->dirs,
            'files' => $this->files,
            'include' => $this->option('include'),
            'exclude' => $this->option('exclude'),
            'force' => $this->option('force'),
            'config' => $this->option('config'),
            'prune' => $this->option('prune'),
        ]);

        return $this->service;
    }

}