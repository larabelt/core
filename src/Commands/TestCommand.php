<?php

namespace Belt\Core\Commands;

use Auth, Morph, Queue;
use Belt\Core\Helpers\BeltHelper;
use Belt\Core\Helpers\UrlHelper;
use Belt\Core\User;
use Illuminate\Console\Command;

/**
 * Class TestCommand
 *
 * Create and copy test DB in sqlite for easier testing
 *
 * @package TN\Cms\Command
 */
class TestCommand extends Command
{

    /**
     * @var string
     */
    protected $signature = 'belt-core:test {action} {--types=} {--subtypes=}';

    /**
     * @var string
     */
    protected $description = 'testing functions';

    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    public $disk;

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function disk()
    {
        return $this->disk = $this->disk ?: BeltHelper::baseDisk();
    }

    /**
     * Fire test DB create and copy command
     *
     * @return void|string
     */
    public function handle()
    {

        $action = $this->argument('action');
        $types = $this->option('types');

        if ($action == 'db') {
            $this->buildTestingDB();
        }

        if ($action == 'responses' && $types) {
            $this->responses($types);
        }

    }

    public function responses($types)
    {
        foreach (explode(',', $types) as $type) {

            $qb = Morph::type2QB($type);

            if ($subtypes = $this->option('subtypes')) {
                $qb->whereIn('subtype', explode(',', $subtypes));
            }

            foreach ($qb->get() as $item) {

                $toggle = false;
                if (in_array('is_active', $item->getAttributes()) && !$item->is_active) {
                    $toggle = true;
                    $item->is_active = true;
                    $item->save();
                }

                try {
                    $url = url($item->default_url);
                    if ($url && !UrlHelper::exists($url)) {
                        $this->warn(sprintf("NOK: %s %s: %s", $type, $item->id, $url));
                    } else {
                        $this->info(sprintf("OK: %s %s: %s", $type, $item->id, $url));
                    }
                } catch (\Exception $e) {

                }

                if ($toggle) {
                    $item->is_active = false;
                    $item->save();
                }

            }
        }
    }

    public function buildTestingDB()
    {
        \Queue::fake();

        putenv("APP_ENV=testing");

        app()['config']->set('belt.clip.default_driver', 'local');
        app()['config']->set('database.default', 'sqlite');
        app()['config']->set('database.connections.sqlite.database', 'database/testing/database.sqlite');

        $path = 'database/testing';

        # replace test DB with empty DB
        $this->disk()->delete("$path/database.sqlite");
        $this->disk()->copy("$path/empty.sqlite", "$path/database.sqlite");

        # run migration on test DB
        $this->call('migrate', ['--env' => 'testing']);

        # seed the db
        $seeders = $this->disk()->files('database/seeds/belt');
        foreach ($seeders as $seeder) {
            if (str_contains($seeder, ['Seeder'])) {
                $seeder = str_replace(['database/seeds/belt/', '.php'], '', $seeder);
                $this->call('db:seed', [
                    '--env' => 'testing',
                    '--class' => $seeder,
                ]);
            }
        }

        # seed the db
        $seeders = $this->disk()->files('database/seeds');
        foreach ($seeders as $seeder) {
            if (str_contains($seeder, ['Seeder'])) {
                $seeder = str_replace(['database/seeds/', '.php'], '', $seeder);
                $this->call('db:seed', [
                    '--env' => 'testing',
                    '--class' => $seeder,
                ]);
            }
        }
    }

}