<?php

namespace Belt\Core\Jobs;

use Belt;
use Belt\Core\Services\BackupService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BackupDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * @var string
     */
    public $key = '';

    /**
     * @var BackupService
     */
    public $service;

    /**
     * @return BackupService
     */
    public function service()
    {
        return $this->service = $this->service ?: new BackupService();
    }

    /**
     * BackupDatabase constructor.
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Execute the job
     *
     * @throws \Exception
     */
    public function handle()
    {
        $this->service()->backup($this->key);
    }

}
