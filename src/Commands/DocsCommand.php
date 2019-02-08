<?php

namespace Belt\Core\Commands;

use Belt;
use Illuminate\Console\Command;

/**
 * Class GenerateCommand
 * @package Belt\Core\Commands
 */
class DocsCommand extends Command
{

    use Belt\Core\Behaviors\HasService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belt-core:docs {action=generate} {--d|doc_version=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate md document files for larabelt site';

    /**
     * @var string
     */
    protected $serviceClass = Belt\Core\Services\DocsService::class;

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle()
    {
        $action = $this->argument('action');

        $service = $this->service();

        if ($action == 'generate') {
            $service->generate($this->option('doc_version'));
        }
    }

}