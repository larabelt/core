<?php
namespace Ohio\Core\Base\Testing;

use Ohio\Core\Base\Helper\OhioHelper;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Session\Store;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NullSessionHandler;

abstract class OhioTestCase extends TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    public function exceptionNotThrown()
    {
        die('Expected Exception Was Not Thrown');
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {

        $paths = [
            __DIR__ . '/../../../../../../bootstrap/app.php',
            __DIR__ . '/../../../../all/bootstrap/app.php',
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                break;
            }
        }

        $app = require $path;

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Copy and paste testDB stub over actual testDB
     *
     * Called frequently during testing to quickly reset
     * the databases values. This prevents changes to the testDB
     * during one test affecting the outcome of another test.
     *
     * @codeCoverageIgnore
     */
    public function refreshDB()
    {

        //app()['config']->set('database.default', 'sqlite');
        //app()['config']->set('database.connections.sqlite.database', 'database/testing/database.sqlite');

        $disk = OhioHelper::baseDisk();

        $path = 'database/testing';

        # create stub DB for unit testing
        $disk->delete("$path/stub.sqlite");
        $disk->copy("$path/database.sqlite", "$path/stub.sqlite");
    }

    /**
     * Flushes the event listeners for Eloquent models
     *
     * This is a hack for testing Eloquent models. If you run multiple tests
     * for the same models, the "boot" routine is skipped during subsequent
     * events such as "saving", which screws up the expected results.
     *
     * @codeCoverageIgnore
     */
    public function resetModels($models)
    {
        // Reset their event listeners.
        foreach ($models as $model) {

            // Flush any existing listeners.
            call_user_func(array($model, 'flushEventListeners'));

            // Reregister them.
            call_user_func(array($model, 'boot'));
        }
    }

    public function getTestSession($name = 'test')
    {
        return new Store($name, new NullSessionHandler());
    }
}
