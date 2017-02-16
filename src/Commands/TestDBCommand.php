<?php
namespace Belt\Core\Commands;

use Belt\Core\Helpers\BeltHelper;

use Illuminate\Console\Command;

/**
 * Class TestDBCommand
 *
 * Create and copy test DB in sqlite for easier testing
 *
 * @package TN\Cms\Command
 */
class TestDBCommand extends Command
{

    protected $signature = 'belt-core:test-db';

    protected $description = 'create and seed test sqlite db';

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
    public function fire()
    {

        if ($this->option('env') != 'testing') {
            return $this->info('this command must with option --env=testing');
        }

        app()['config']->set('database.default', 'sqlite');
        app()['config']->set('database.connections.sqlite.database', 'database/testing/database.sqlite');

        $path = 'database/testing';

        # replace test DB with empty DB
        $this->disk()->delete("$path/database.sqlite");
        $this->disk()->copy("$path/empty.sqlite", "$path/database.sqlite");

        # run migration on test DB
        $this->call('migrate', ['--env' => 'testing']);

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