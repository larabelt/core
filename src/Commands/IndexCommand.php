<?php

namespace Belt\Core\Commands;

use Belt;
use Belt\Core\Services\IndexService;
use Illuminate\Console\Command;

/**
 * Class IndexCommand
 * @package Belt\Core\Commands
 */
class IndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belt-core:index {action} {--type=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * @var IndexService
     */
    public $service;

    /**
     * @return IndexService
     */
    public function service()
    {
        return $this->service ?: $this->service = new IndexService(['console' => $this]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument('action');

        if ($action == 'merge-schema' && $type = $this->option('type')) {
            foreach (explode(',', $type) as $type) {
                $this->service()->mergeSchema($type);
            }
        }

        if ($action == 'batch-upsert' && $type = $this->option('type')) {
            foreach (explode(',', $type) as $type) {
                $this->service()->batchUpsert($type);
            }
        }

    }

}