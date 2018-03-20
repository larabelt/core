<?php

namespace Belt\Core\Services;

use Belt, DB, Spatie, Storage;
use Belt\Core\Behaviors\TmpFile;
use Belt\Core\Behaviors\HasConfig;
use Belt\Core\Jobs\BackupDatabase;
use Illuminate\Database\Connection;

/**
 * Class BackupService
 * @package Belt\Core\Services
 */
class BackupService
{
    use HasConfig, TmpFile;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    public $disk;

    /**
     * @var resource|bool a file handle
     */
    public $tmpFile;

    /**
     * @return string
     */
    public function configPath()
    {
        return 'belt.core.backup';
    }

    /**
     * @param $groupKey
     */
    public function setGroupOptions($groupKey)
    {
        $defaults = [
            'name' => $groupKey,
            'disk' => $this->config('defaults.disk'),
            'connectionName' => $this->config('defaults.connectionName') ?: config('database.default'),
            'relPath' => $this->config('defaults.relPath') ?: "backups/$groupKey",
            'filename' => sprintf('%s.sql', (new \DateTime())->format('Ymd.His')),
            'expires' => ''
        ];

        $options = array_merge($defaults, $this->config("groups.$groupKey"));

        $relPath = $this->option('relPath');
        if ($relPath instanceof \Closure) {
            $options['relPath'] = $relPath->call($this);
        }

        $filename = $this->option('filename');
        if ($filename instanceof \Closure) {
            $options['filename'] = $filename->call($this);
        }

        $options['path'] = sprintf('%s/%s', $options['relPath'], $options['filename']);

        $this->disk = $options['disk'];

        $this->options = $options;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function option($key, $default = null)
    {
        return array_get($this->options, $key, $default);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getDatabaseConfig($key, $default = null)
    {
        $config = config(sprintf('database.connections.%s', $this->option('connectionName')));

        return array_get($config, $key, $default);
    }

    /**
     * @param $key
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    public function disk($key)
    {
        return Storage::disk($key);
    }

    /**
     * Run through backup group options
     * @param null $group
     */
    public function run($group = null)
    {
        $groups = $group ? (array) $group : array_keys($this->config('groups'));

        foreach ($groups as $group) {
            if (array_get($this->config(), 'groups.' . $group)) {
                dispatch(new BackupDatabase($group));
            }
        }
    }

    /**
     * Create backup dump file
     *
     * @param $groupKey
     * @throws Spatie\DbDumper\Exceptions\CannotSetParameter
     * @throws \Exception
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function backup($groupKey)
    {
        // options
        $this->setGroupOptions($groupKey);
        $this->connection = DB::connection($this->option('connectionName'));

        // build dumper
        $dumper = $this->getDumper();
        if ($include = $this->option('include')) {
            $dumper->includeTables($include);
        } elseif ($exclude = $this->option('exclude')) {
            $dumper->excludeTables($exclude);
        }

        // write file
        $this->createTmpFile();
        $dumper->dumpToFile($this->getTmpFileUri());
        $disk = $this->disk($this->option('disk'));
        $disk->put($this->option('path'), $this->getTmpFileContents());

        // remove old files
        $this->purge();
    }

    /**
     * Remove old backup files
     *
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function purge()
    {
        if ($expires = $this->option('expires')) {

            $now = strtotime('now');
            $window = abs($now - abs(strtotime($expires)));

            $disk = $this->disk($this->option('disk'));

            foreach ($disk->files($this->option('relPath')) as $file) {
                if (($now - $window) > $disk->getTimestamp($file)) {
                    $disk->delete($file);
                }
            }
        }
    }

    /**
     * @return Spatie\DbDumper\DbDumper
     * @throws \Exception
     */
    public function getDumper()
    {
        switch ($this->getDatabaseConfig('driver')) {
            case 'mysql':
                $dumper = $this->getDumperMysql();
                break;
        }

        if (!isset($dumper)) {
            throw new \Exception('invalid database driver');
        }

        return $dumper;
    }

    /**
     * @return \Spatie\DbDumper\DbDumper
     */
    public function getDumperMysql()
    {
        $dumper = Spatie\DbDumper\Databases\MySql::create();
        $dumper->setDbName($this->getDatabaseConfig('database'));
        $dumper->setUserName($this->getDatabaseConfig('username'));
        $dumper->setPassword($this->getDatabaseConfig('password'));

        return $dumper;
    }

}