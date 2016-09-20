<?php

namespace Ohio\Core\Base\Commands;

use Storage;
use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\FilesystemManager;

class AssetsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ohio:assets {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'publish sub vendor items';

    protected $force = false;

    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $disk;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->force = $this->option('force');

        /**
         * @var $app ['config'] \Illuminate\Config\Repository
         */
        $app = app();
        $app['config']->set('filesystems.disks.base', [
            'driver' => 'local',
            'root' => base_path(),
        ]);
        $this->disk = (new FilesystemManager($app))->disk('base');

        $paths = [
            'node_modules/admin-lte/bootstrap' => 'public/adminlte/bootstrap',
            'node_modules/admin-lte/dist' => 'public/adminlte/dist',
            'node_modules/admin-lte/plugins' => 'public/adminlte/plugins',
            'node_modules/angular/css' => 'public/css/font-awesome',
            'node_modules/font-awesome/css' => 'public/css/font-awesome',
            'node_modules/font-awesome/fonts' => 'public/fonts',
        ];

        foreach ($paths as $src_path => $target_path) {
            $this->publishDirectory($src_path, $target_path);
        }

        $files = [
            'node_modules/angular/angular.min.js' => 'public/js/angular/angular.min.js',
            'node_modules/angular-route/angular-route.min.js' => 'public/js/angular/angular-route.min.js',
            'node_modules/angular-ui-bootstrap/dist/ui-bootstrap.js' => 'public/js/angular/ui-bootstrap.js',
        ];

        foreach ($files as $src_path => $target_path) {
            $this->publishFile($src_path, $target_path);
        }

    }

    public function publishDirectory($src_path, $target_path)
    {

        if ($this->force) {
            $this->disk->deleteDirectory($target_path);
        }

        $files = $this->disk->allFiles($src_path);

        foreach ($files as $file) {
            $rel_src_path = str_replace($src_path, '', $file);
            $save_path = $target_path . $rel_src_path;
            $this->publishFile($file, $save_path);
        }
    }

    public function publishFile($src_path, $save_path)
    {

        if ($this->disk->exists($src_path)) {
            if ($this->force && $this->disk->exists($save_path)) {
                $this->disk->delete($save_path);
            }
            if (!$this->disk->exists($save_path)) {
                $this->disk->copy($src_path, $save_path);
                $this->info($save_path);
            }
        }
    }
}