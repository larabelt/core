<?php

namespace Belt\Core\Commands;

use Belt\Core\Services\BackupService;
use Illuminate\Console\Command;

/**
 * Class BackupCommand
 * @package Belt\Core\Commands
 */
class BackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belt-core:backup {--group=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * @var BackupService
     */
    public $service;

    /**
     * @return BackupService
     */
    public function service()
    {
        return $this->service ?: $this->service = new BackupService();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->service()->run($this->option('group'));
    }

}