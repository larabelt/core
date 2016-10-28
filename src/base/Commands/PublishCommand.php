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

    protected $created = [];

    protected $modified = [];

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

        app()['config']->set('filesystems.disks.base', ['driver' => 'local', 'root' => base_path()]);

        $this->disk = (new FilesystemManager(app()))->disk('base');
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

        if ($this->created) {
            $this->info("\nThe following files were added:\n");
            foreach ($this->created as $file) {
                $this->info($file);
            }
        }

        if ($this->modified) {
            $this->info("\nThe following files were overwritten:\n");
            foreach ($this->modified as $file) {
                $this->info($file);
            }
        }

        if ($this->ignored) {
            $this->warn("\nThe following files were ignored though source files have changed:\n");
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
     *
     * @return boolean|void
     */
    public function considerCopyingFile($srcPath, $targetPath)
    {
        $srcContents = $this->disk->get($srcPath);

        $history = $this->getFilePublishHistory($targetPath);

        if (!$this->disk->exists($targetPath)) {
            return $this->createFile($targetPath, $srcContents, $history);
        }

        if ($this->force) {
            return $this->replaceFile($targetPath, $srcContents, $history);
        }

        $targetHash = md5($this->disk->get($targetPath));

        /**
         * If the target file exists but the history is missing then we're going to
         * ignore it.
         */
        if (!$history->hash) {
            return $this->ignored[] = $targetPath;
        }

        /**
         * If saved hash does not match the current hash, then it appears
         * this file has been locally edited and should not be replaced.
         */
        if ($history->hash != $targetHash) {
            return $this->ignored[] = $targetPath;
        }

        /**
         * The target file appears not to be edited locally while the source file
         * looks to have been updated. We're going to replace it.
         */
        if (md5($srcContents) != $targetHash) {
            return $this->replaceFile($targetPath, $srcContents, $history);
        }

        /**
         * If we've made it this far, then the source and target file are the same.
         * Nothing needs to happen.
         */
    }

    public function createFile($path, $contents, $history)
    {
        $result = $this->putFile($path, $contents, $history);

        if ($result) {
            $this->created[] = $path;
        }

        return $result;
    }

    public function replaceFile($path, $contents, $history)
    {
        $result = $this->putFile($path, $contents, $history);

        if ($result) {
            $this->modified[] = $path;
        }

        return $result;
    }

    public function putFile($path, $contents, $history)
    {
        $result = $this->disk->put($path, $contents);

        if ($result) {
            $history->update(['hash' => md5($contents)]);
        }

        return $result;
    }

    public function getFilePublishHistory($path)
    {
        return PublishHistory::firstOrCreate(['path' => $path]);
    }

}