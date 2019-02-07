<?php

namespace Belt\Core\Services;

use DB;
use Belt\Core\Behaviors\HasDisk;
use Illuminate\Support\Facades\Schema;
use Matrix\Exception;

/**
 * Class PublishService
 * @package Belt\Core\Services
 */
class PublishService
{

    use HasDisk;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $historyPath;

    /**
     * @var bool|mixed
     */
    public $force = false;

    /**
     * @var string
     */
    public $include = '';

    /**
     * @var string
     */
    public $exclude = '';

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
     * @var array
     */
    public $history = [];

    /**
     * PublishService constructor.
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->key = array_get($options, 'key', '');
        $this->dirs = array_get($options, 'dirs', []);
        $this->files = array_get($options, 'files', []);
        $this->force = array_get($options, 'force', false);

        $include = array_get($options, 'include', '');
        $exclude = array_get($options, 'exclude', '');

        $this->include = array_filter(explode(',', $include));
        $this->exclude = array_filter(explode(',', $exclude));

        if (!array_get($options, 'config')) {
            $this->exclude[] = 'config/belt';
        }

        $this->historyPath = config('belt.core.publish.history_path', 'database/history/publish/');
    }

    /**
     * Create one-time file with hashes from table. Future operations will only use text files.
     */
    public function createHistoryFromTable()
    {
        if (Schema::hasTable('publish_history')) {
            foreach (DB::table('publish_history')->orderBy('path')->get() as $row) {
                $this->addHistory($row->path, $row->hash, $row->updated_at);
            };
            $this->force = true;
            $this->writeHistoryToFile();
        }
    }

    /**
     * @param $path
     * @param $hash
     * @param null $timestamp
     */
    public function addHistory($path, $hash, $timestamp = null)
    {
//        $exempt = ['.DS_Store'];
//
//        if (in_array(basename($path), $exempt)) {
//            return;
//        }

        $timestamp = $timestamp ?: date('Y-m-d H:i:s');
        $hash = preg_match('/^[a-f0-9]{32}$/', $hash) ? $hash : md5($hash);

        $this->history[$path]['timestamp'] = $timestamp;
        $this->history[$path]['hash'] = $hash;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function publish()
    {
        $this->readHistoryFromFile();

        foreach ($this->dirs as $src_dir => $target_dir) {
            $this->publishDir($src_dir, $target_dir);
        }

        $this->publishFiles($this->files);

        $this->writeHistoryToFile();
    }

    /**
     * @return bool|string
     * @throws Exception
     */
    public function getPreviousHistoryContents()
    {
        $path = sprintf("%s/%s", $this->historyPath, $this->key);
        $historyFiles = $this->disk()->allFiles($path);
        $historyFile = array_pop($historyFiles);

        if (!$historyFile) {
            $this->createHistoryFromTable();
            $path = sprintf("%s/%s", $this->historyPath, $this->key);
            $historyFiles = $this->disk()->allFiles($path);
            $historyFile = array_pop($historyFiles);
        }

        if (!$historyFile) {
            throw new Exception('missing history file for publish ' . $this->key);
        }

        return file_get_contents(base_path($historyFile));
    }

    /**
     * Load previous publish history into publish array
     */
    public function readHistoryFromFile()
    {
        $contents = $this->getPreviousHistoryContents();

        foreach (explode("\n", $contents) as $line) {

            $bits = explode('|', $line);
            if (!$line || count($bits) != 3) {
                continue;
            }

            $file = trim($bits[0]);
            $timestamp = trim($bits[2]);
            $hash = trim($bits[1]);

            $this->addHistory($file, $hash, $timestamp);
        }
    }

    /**
     * @param $src_dir
     * @param $target_dir
     */
    public function publishDir($src_dir, $target_dir)
    {
        $files = $this->disk()->allFiles($src_dir);

        $include = $this->include ?: [];
        $exclude = $this->exclude ?: [];

        foreach ($files as $file) {
            $rel_src_path = str_replace($src_dir, '', $file);
            $save_path = $target_dir . $rel_src_path;
            if (!$include || str_contains($save_path, $include)) {
                if ($exclude && str_contains($save_path, $exclude)) {
                    continue;
                }
                $this->evalFile($file, $save_path);
            }
        }
    }

    /**
     * @param array $files
     */
    public function publishFiles($files = [])
    {
        $files = $files ?: $this->files;

        $include = $this->include ?: [];
        $exclude = $this->exclude ?: [];

        foreach ($files as $src_file => $target_file) {
            if (!$include || str_contains($src_file, $include)) {
                if ($exclude && str_contains($src_file, $exclude)) {
                    continue;
                }
                $this->evalFile($src_file, $target_file);
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
        $exempt = ['.DS_Store'];
        if (str_contains($srcPath, $exempt)) {
            return;
        }

        $srcContents = $this->disk()->get($srcPath);

        /**
         * Target file hasn't been created yet, so go ahead.
         */
        if (!$this->disk()->exists($targetPath)) {
            return $this->createFile($targetPath, $srcContents);
        }

        /**
         * We're forcing things, so go ahead.
         */
        if ($this->force) {
            return $this->replaceFile($targetPath, $srcContents);
        }

        $historyHash = $this->getHistoryHash($targetPath);

        $targetHash = md5($this->disk()->get($targetPath));

        /**
         * If the target file exists but the history is missing then we're going to
         * ignore it.
         */
        if (!$historyHash) {
            return $this->ignored[] = $targetPath;
        }

        /**
         * If saved hash does not match the current hash, then it appears
         * this file has been locally edited and should not be replaced.
         */
        if ($historyHash != $targetHash) {
            return $this->ignored[] = $targetPath;
        }

        /**
         * The target file appears not to be edited locally while the source file
         * looks to have been updated. We're going to replace it.
         */
        if (md5($srcContents) != $targetHash) {
            return $this->replaceFile($targetPath, $srcContents);
        }

        /**
         * If we've made it this far, then the source and target file are the same.
         * Nothing needs to happen.
         */
    }


    /**
     * @param $path
     * @param $contents
     * @return bool
     */
    public function createFile($path, $contents)
    {
        if ($result = $this->putFile($path, $contents)) {
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
    public function replaceFile($path, $contents)
    {
        if ($result = $this->putFile($path, $contents)) {
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
    public function putFile($path, $contents)
    {
        if ($result = $this->disk()->put($path, $contents)) {
            $this->addHistory($path, $contents);
        }

        return $result;
    }

    /**
     * Convert history array to text file
     */
    public function writeHistoryToFile()
    {
        try {
            $maxlen = max(array_map('strlen', array_keys($this->history)));
        } catch (\Exception $e) {
            $maxlen = 100;
        }

        ksort($this->history);

        $contents = '';
        foreach ($this->history as $path => $row) {
            $line = sprintf("%s|%s|%s", str_pad($path, $maxlen), $row['hash'], $row['timestamp']);
            $contents = $contents ? "$contents\n$line" : $line;
        }

        $path = sprintf("%s/%s/%s.txt",
            $this->historyPath,
            $this->key,
            date('YmdHis', strtotime('now')));

        if ($this->force || $contents != $this->getPreviousHistoryContents()) {
            $this->disk()->put($path, $contents);
        }

    }

    /**
     * @param $path
     * @return mixed
     */
    public function getHistoryHash($path)
    {
        if ($history = array_get($this->history, $path)) {
            return $history['hash'];
        };
    }

}