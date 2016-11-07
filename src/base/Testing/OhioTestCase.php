<?php
namespace Ohio\Core\Base\Testing;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase;

abstract class OhioTestCase extends TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {

        $paths = [
            __DIR__ . '/../../../../../../bootstrap/app.php',
            __DIR__ . '/../../../../demo/bootstrap/app.php',
        ];

        foreach($paths as $path) {
            if (file_exists($path)) {
                break;
            }
        }

        $app = require $path;

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
