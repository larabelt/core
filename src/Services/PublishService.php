<?php

namespace Belt\Core\Services;

use Belt\Core\PublishHistory;
use Belt\Core\Helpers\BeltHelper;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class PublishService
 * @package Belt\Core\Services
 */
class PublishService
{

    /**
     * @var bool|mixed
     */
    public $force = false;

    /**
     * @var string
     */
    public $path = null;

    /**
     * @var array|mixed
     */
    public $dirs = [];

    /**
     * @var array|mixed
     */
    public $files = [];

    /**
     * @var array
     */
    public $created = [];

    /**
     * @var array
     */
    public $modified = [];

    /**
     * @var array
     */
    public $ignored = [];

    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    public $disk;

    /**
     * PublishService constructor.
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->dirs = array_get($options, 'dirs', []);
        $this->files = array_get($options, 'files', []);
        $this->force = array_get($options, 'force', false);
        $this->path = array_get($options, 'path', []);
    }

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function disk()
    {
        return $this->disk = $this->disk ?: BeltHelper::baseDisk();
    }

    /**
     * Create "publish_history" table if it does not exist.
     */
    public function setPublishHistoryTable()
    {
        if (!Schema::hasTable('publish_history')) {
            Schema::create('publish_history', function (Blueprint $table) {
                $table->increments('id');
                $table->string('path')->unique();
                $table->string('hash')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function publish()
    {
        $this->setPublishHistoryTable();

        foreach ($this->dirs as $src_dir => $target_dir) {
            $this->publishDir($src_dir, $target_dir);
        }
    }

    /**
     * Update history hashes
     *
     * @return mixed
     */
    public function hash()
    {
        $this->setPublishHistoryTable();

        $histories = PublishHistory::all();
        foreach ($histories as $history) {
            $hash = md5($this->disk()->get($history->path));
            $history->update(['hash' => $hash]);
        }
    }

    /**
     * @param $src_dir
     * @param $target_dir
     */
    public function publishDir($src_dir, $target_dir)
    {

        $files = $this->disk()->allFiles($src_dir);

        foreach ($files as $file) {
            $rel_src_path = str_replace($src_dir, '', $file);
            $save_path = $target_dir . $rel_src_path;
            if (!$this->path || str_contains($save_path, explode(',', $this->path))) {
                $this->evalFile($file, $save_path);;
            }
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
    public function evalFile($srcPath, $targetPath)
    {
        $srcContents = $this->disk()->get($srcPath);

        $history = $this->getFilePublishHistory($targetPath);

        if (!$this->disk()->exists($targetPath)) {
            return $this->createFile($targetPath, $srcContents, $history);
        }

        if ($this->force) {
            return $this->replaceFile($targetPath, $srcContents, $history);
        }

        $targetHash = md5($this->disk()->get($targetPath));

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

    /**
     * @param $path
     * @param $contents
     * @param $history
     * @return bool
     */
    public function createFile($path, $contents, $history)
    {
        $result = $this->putFile($path, $contents, $history);

        if ($result) {
            $this->created[] = $path;
        }

        return $result;
    }

    /**
     * @param $path
     * @param $contents
     * @param $history
     * @return bool
     */
    public function replaceFile($path, $contents, $history)
    {
        $result = $this->putFile($path, $contents, $history);

        if ($result) {
            $this->modified[] = $path;
        }

        return $result;
    }

    /**
     * @param $path
     * @param $contents
     * @param $history
     * @return bool
     */
    public function putFile($path, $contents, $history)
    {
        $result = $this->disk()->put($path, $contents);

        if ($result) {
            $history->update(['hash' => md5($contents)]);
        }

        return $result;
    }

    /**
     * @param $path
     * @return mixed
     */
    public function getFilePublishHistory($path)
    {
        return PublishHistory::firstOrCreate(['path' => $path]);
    }

}