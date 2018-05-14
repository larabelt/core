<?php

namespace Belt\Core\Commands;

use Illuminate\Console\Command;
use Belt\Core\Commands\Behaviors\ProcessTrait;

/**
 * Class BeltCommand
 * @package Belt\Core\Commands
 */
class BeltCommand extends Command
{
    use ProcessTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belt {action} {--force} {--include=} {--exclude=} {--config}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument('action');

        if ($action == 'publish') {
            return $this->publish($this->options());
        }

        if ($action == 'migrate') {
            return $this->migrate();
        }

        if ($action == 'refresh') {
            $this->refresh();
        }

        if ($action == 'seed') {
            return $this->seed();
        }
    }

    /**
     * @param array $options
     */
    public function publish($options = [])
    {
        foreach (app('belt')->publish() as $cmd) {
            $this->info($cmd);
            $this->call($cmd, [
                '--force' => (bool) array_get($options, 'force', false),
                '--include' => (string) array_get($options, 'include'),
                '--exclude' => (string) array_get($options, 'exclude'),
                '--config' => (string) array_get($options, 'config'),
            ]);
        }

        $this->process('composer dumpautoload');
    }

    /**
     *
     */
    public function migrate()
    {
        $this->call('migrate', ['--force' => $this->option('force'), '--path' => 'database/migrations/belt']);
        $this->call('migrate', ['--force' => $this->option('force')]);
    }

    /**
     *
     */
    public function seed()
    {
        foreach (app('belt')->seeders() as $class) {
            $this->info('db:seed --class=' . $class);
            $this->call('db:seed', ['--class' => $class]);
        }
    }

    /**
     *
     */
    public function refresh()
    {
        $this->publish(['force' => true]);
        $this->info('migrate:refresh');
        $this->call('migrate:refresh', ['--path' => 'database/migrations/belt']);
        $this->call('migrate:refresh');
        $this->seed();
    }

}