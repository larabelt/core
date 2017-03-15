<?php

namespace Belt\Core\Commands;

use Belt\Core\Services\AlertService;
use Illuminate\Console\Command;

/**
 * Class AlertCommand
 * @package Belt\Core\Commands
 */
class AlertCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belt-core:alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * @var AlertService
     */
    public $service;

    /**
     * @return AlertService
     */
    public function service()
    {
        return $this->service ?: $this->service = new AlertService();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->service()->cache();
    }

}