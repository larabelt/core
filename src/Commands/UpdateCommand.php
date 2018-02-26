<?php

namespace Belt\Core\Commands;

use Belt;
use Belt\Core\Services\Update\UpdateService;
use Illuminate\Console\Command;

/**
 * Class UpdateCommand
 * @package Belt\Core\Commands
 */
class UpdateCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belt-core:update {--v=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'run updates';

    /**
     * @var UpdateService
     */
    private $service;

    /**
     * @return UpdateService
     */
    public function service()
    {
        $this->service = $this->service ?: new UpdateService([
            'console' => $this,
        ]);

        return $this->service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $service = $this->service();

        $version = $this->option('v') ?: Belt\Core\BeltCoreServiceProvider::VERSION;

        $service->registerUpdates();

        $service->run($version);
    }


}