<?php

namespace Ohio\Core\Base\Console\Commands;

use Artisan, Storage;
use Illuminate\Console\Command;

class ClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ohio:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clear app cache';

    protected $disk;

    protected $keepers = [
        '.gitignore',
        '.gitkeep',
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $env = env('APP_ENV');

        Artisan::call('cache:clear', ['--env' => $env]);
        Artisan::call('clear', ['--env' => $env]);

        $this->disk = Storage::disk('local');
        $this->disk->getDriver()->getAdapter()->setPathPrefix(storage_path());

        $this->clear('framework/cache');
        $this->clear('framework/views');

        if ($env == 'local') {
            $this->info(exec('sudo service php5-fpm restart'));
        }
    }

    private function clear($path)
    {

        $files = $this->disk->files($path);

        foreach ($files as $file) {
            if (str_contains($file, $this->keepers)) {
                continue;
            }
            $this->disk->delete($file);
        }

        $this->info("path $path cleared");
    }

}