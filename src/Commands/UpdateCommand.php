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
    protected $signature = 'belt-core:update {package} {update*}';

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
            'package' => $this->argument('package'),
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

        if ($update = $this->argument('update')) {
            $service->run($update);
        }

    }


}