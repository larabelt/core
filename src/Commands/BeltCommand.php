<?php

namespace Belt\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * Class BeltCommand
 * @package Belt\Core\Commands
 */
class BeltCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belt {action} {--force}';

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

        if ($action == 'seed') {
            return $this->seed();
        }

        if ($action == 'install') {
            if (!file_exists(base_path('.env'))) {
                try {
                    exec('cp .env.example .env');
                } catch (\Exception $c) {

                }
            }
            try {
                exec('composer install');
            } catch (\Exception $c) {

            }
            $this->info('key:generate');
            $this->call('key:generate');
            $this->publish(['force' => true]);
            $this->info('migrate');
            $this->call('migrate');
            $this->seed();
        }

        if ($action == 'refresh') {
            $this->publish(['force' => true]);
            $this->info('migrate:refresh');
            $this->call('migrate:refresh');
            $this->seed();
        }
    }

    public function publish($options = [])
    {
        foreach (app('belt')->publish() as $cmd) {
            $this->info($cmd);
            $this->call($cmd, [
                '--force' => (bool) array_get($options, 'force', false)
            ]);
        }
        try {
            exec('composer dumpautoload');
        } catch (\Exception $c) {

        }
    }

    public function seed()
    {
        foreach (app('belt')->seeders() as $class) {
            $this->info('db:seed --class=' . $class);
            $this->call('db:seed', ['--class' => $class]);
        }
    }


}