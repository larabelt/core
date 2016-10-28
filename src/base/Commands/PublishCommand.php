<?php

namespace Ohio\Core\Base\Commands;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Ohio\Core\Base\PublishHistory;
use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemManager;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ohio-core:publish {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'publish assets for ohio core';

    protected $force = false;

    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $disk;

    protected $saved = [];

    protected $ignored = [];

    protected $dirs = [
        'node_modules/admin-lte/bootstrap' => 'public/adminlte/bootstrap',
        'node_modules/admin-lte/dist' => 'public/adminlte/dist',
        'node_modules/admin-lte/plugins' => 'public/adminlte/plugins',
        'node_modules/font-awesome/css' => 'public/css/font-awesome',
        'node_modules/font-awesome/fonts' => 'public/fonts',
        'vendor/ohiocms/core/resources' => 'resources/ohio/core',
        'vendor/ohiocms/core/database/factories' => 'database/factories',
        'vendor/ohiocms/core/database/migrations' => 'database/migrations',
        'vendor/ohiocms/core/database/seeds' => 'database/seeds',
    ];

    public function __construct()
    {
        parent::__construct();


    }

    public function init()
    {
        if (!Schema::hasTable('publish_history')) {
            Schema::create('publish_history', function (Blueprint $table) {
                $table->increments('id');
                $table->string('path')->unique();
                $table->string('hash')->nullable();
                $table->timestamps();
            });
        }

        PublishHistory::unguard();

        $this->force = $this->option('force');

        /**
         * @var $app ['config'] \Illuminate\Config\Repository
         */
        $app = app();

        $app['config']->set('filesystems.disks.base', ['driver' => 'local', 'root' => base_path()]);

        $this->disk = (new FilesystemManager($app))->disk('base');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->init();

        foreach ($this->dirs as $src_dir => $target_dir) {
            $this->publishDir($src_dir, $target_dir);
        }

        if ($this->saved) {
            $this->info("\nThe following files were published:\n");
            foreach ($this->saved as $file) {
                $this->info($file);
            }
        }

        if ($this->ignored) {
            $this->warn("\nThe following files were ignored:\n");
            foreach ($this->ignored as $file) {
                $this->warn($file);
            }
        }

    }

    public function publishDir($src_dir, $target_dir)
    {

        $files = $this->disk->allFiles($src_dir);

        foreach ($files as $file) {
            $rel_src_path = str_replace($src_dir, '', $file);
            $save_path = $target_dir . $rel_src_path;
            $this->considerCopyingFile($file, $save_path);
        }
    }

    /**
     * Consider copying file to target path
     *
     * @param $srcPath
     * @param $targetPath
     */
    public function considerCopyingFile($srcPath, $targetPath)
    {
        $srcContents = $this->disk->get($srcPath);

        $history = $this->getFilePublishHistory($targetPath);

        if ($this->force) {
            return $this->putFile($targetPath, $srcContents, $history);
        }

        if (!$this->disk->exists($targetPath)) {
            return $this->putFile($targetPath, $srcContents, $history);
        }

        $targetContents = $this->disk->get($targetPath);

        /**
         * If the hash saved in the database matches the hash of the current file,
         * then consider it unchanged and eligible to be overwritten.
         */
        if (!$history->hash || $history->hash == md5($targetContents)) {
            return $this->putFile($targetPath, $srcContents, $history);
        }

        $this->ignored[] = $targetPath;
    }

    public function putFile($path, $contents, $history = null)
    {

        $this->saved[] = $path;

        $this->disk->put($path, $contents);

        $history = $history ?: $this->getFilePublishHistory($path);

        $history->update(['hash' => md5($contents)]);
    }

    public function getFilePublishHistory($path)
    {
        return PublishHistory::firstOrCreate(['path' => $path]);
    }

}