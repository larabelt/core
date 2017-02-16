<?php

namespace Belt\Core\Commands;

use Belt\Core\Services\PublishService;

use Illuminate\Console\Command;

class PublishCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belt-core:publish {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'publish assets for belt core';

    protected $dirs = [
        'node_modules/admin-lte/bootstrap' => 'public/adminlte/bootstrap',
        'node_modules/admin-lte/dist' => 'public/adminlte/dist',
        'node_modules/admin-lte/plugins' => 'public/adminlte/plugins',
        'node_modules/font-awesome/css' => 'public/fonts',
        'node_modules/font-awesome/fonts' => 'public/fonts',
        'vendor/larabelt/core/config' => 'config/belt',
        'vendor/larabelt/core/resources' => 'resources/belt/core',
        'vendor/larabelt/core/database/factories' => 'database/factories',
        'vendor/larabelt/core/database/migrations' => 'database/migrations',
        'vendor/larabelt/core/database/seeds' => 'database/seeds',
        'vendor/larabelt/core/database/testing' => 'database/testing',
    ];

    protected $files = [];

    /**
     * @var PublishService
     */
    private $service;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $service = $this->getService();

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

    public function getService()
    {
        $this->service = $this->service ?: new PublishService([
            'force' => $this->option('force'),
            'dirs' => $this->dirs,
            'files' => $this->files
        ]);

        return $this->service;
    }

}