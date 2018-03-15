<?php

namespace Belt\Core\Services;

use Belt, DB, Schema, Spatie, Storage;
use Belt\Core\Behaviors\HasConfig;

/**
 * Class BackupService
 * @package Belt\Core\Services
 */
class BackupService
{
    use HasConfig;

    private $connectionName = 'mysql';

    private $connection = 'mysql';

    /**
     * @return string
     */
    public function configPath()
    {
        return 'belt.core.backup';
    }

    public function reset()
    {
        $this->connectionName = null;
        $this->connection = null;
    }

    /**
     * @param string $name
     */
    public function setConnectionName($name = null)
    {
        $name = $name ?: $this->config('defaults.connection', config('database.default'));

        $this->connectionName = $name;
    }

    public function setConnection($connection = null)
    {
        $connection = $connection ?: DB::connection($this->connectionName);

        $this->connection = $connection;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getDatabaseConfig($key)
    {
        return config(sprintf('database.connections.%s.%s', $this->connectionName, $key));
    }


    public function getAllTables()
    {
        return $this->connection->getDoctrineSchemaManager()->listTableNames();
    }


    public function run()
    {
        $config = $this->getConfig();
        foreach (array_get($config, 'groups', []) as $options) {
            $this->backup($options);
        }

    }

    public function backup($options)
    {
        $this->reset();

        dump($options);

        $this->setConnectionName(array_get($options, 'connection'));
        $this->setConnection();

        dump($this->getDatabaseConfig('database'));
        dump($this->getDatabaseConfig('username'));
        dump($this->getDatabaseConfig('password'));

        $tables = [];
        if ($whitelist = array_get($options, 'whitelist')) {
            $tables = array_intersect($this->getAllTables(), $whitelist);
        }
        if ($blacklist = array_get($options, 'blacklist')) {
            $tables = array_diff($this->getAllTables(), $blacklist);
        }

        switch ($this->getDatabaseConfig('driver')) {
            case 'mysql':
                $this->dumpMysql($tables);
                break;
        }


    }

    public function dumpMysql($tables = [])
    {
        dump(333);
        dump($tables);
        exit;
        Spatie\DbDumper\Databases\MySql::create()
            ->setDbName($databaseName)
            ->setUserName($userName)
            ->setPassword($password)
            ->dumpToFile('dump.sql');
    }

}