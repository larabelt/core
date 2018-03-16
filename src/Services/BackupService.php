<?php

namespace Belt\Core\Services;

use Belt, DB, Spatie, Storage;
use Belt\Core\Behaviors\HasConfig;
use Illuminate\Database\Connection;
use Mockery\Exception;

/**
 * Class BackupService
 * @package Belt\Core\Services
 */
class BackupService
{
    use HasConfig;

    /**
     * @var string
     */
    private $connectionName = 'mysql';

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $path = '';

    /**
     * @return string
     */
    public function configPath()
    {
        return 'belt.core.backup';
    }

    /**
     * reset class properties
     */
    public function reset()
    {
        $this->connectionName = 'mysql';
        $this->connection = null;
        $this->path = '';
    }

    /**
     * @param string $name
     */
    public function setConnectionName($name = null)
    {
        $name = $name ?: $this->config('defaults.connection', config('database.default'));

        $this->connectionName = $name;
    }

    /**
     * @param Connection $connection
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param null $path
     * @return mixed|null|string
     */
    public function setPath($path = null)
    {
        $path = $path ?: $this->config('defaults.path');

        if ($path instanceof \Closure) {
            $path = $path->call($this);
        }

        if (!$path) {
            $path = sprintf('backups/%s/dump.sql', (new \DateTime())->format('Ymd.v'));
            $disk = Storage::disk('local');
            $disk->put($path, '');
        }

        return $this->path = storage_path("app/$path");
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getDatabaseConfig($key)
    {
        return config(sprintf('database.connections.%s.%s', $this->connectionName, $key));
    }

    /**
     * Run through backup group options
     */
    public function run()
    {
        $config = $this->getConfig();
        foreach (array_get($config, 'groups', []) as $options) {
            $this->backup($options);
        }

    }

    /**
     * Create backup dump file
     *
     * @param $options
     */
    public function backup($options)
    {
        //dump($options);

        $this->reset();
        $this->setConnectionName(array_get($options, 'connection'));
        $this->setConnection(DB::connection($this->connectionName));
        $this->setPath(array_get($options, 'path'));

        $dumper = $this->getDumper();

        if ($whitelist = array_get($options, 'whitelist')) {
            $dumper->includeTables($whitelist);
        } elseif ($blacklist = array_get($options, 'blacklist')) {
            $dumper->excludeTables($blacklist);
        }

        $dumper->dumpToFile($this->path);
    }

    /**
     * @return \Spatie\DbDumper\DbDumper
     */
    public function getDumper()
    {
        switch ($this->getDatabaseConfig('driver')) {
            case 'mysql':
                $dumper = $this->getDumperMysql();
                break;
        }

        if (!isset($dumper)) {
            throw new Exception('invalid database driver');
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