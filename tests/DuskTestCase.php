<?php

namespace Tests\Belt\Core;

use Belt\Core\BeltSingleton;
use Tests\Belt\Core\Base\RefreshDatabase;
use Dotenv\Dotenv;
use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Illuminate\Contracts\Console\Kernel;

abstract class DuskTestCase extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        (new Dotenv(__DIR__))->overload();

        $app = require __DIR__ . '/../../all/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * This method is called before the first test of this test class is run.
     */
    public static function setUpBeforeClass()
    {

    }

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->refreshDB();

        $this->setUpBrowserScreenshotPath();
    }

    /**
     * Override default browser screenshot path
     */
    public function setUpBrowserScreenshotPath()
    {
        Browser::$storeScreenshotsAt = public_path(sprintf(
            'tests/screenshots/%s',
            (new BeltSingleton)->guessPackage(get_called_class(), 2)
        ));

        if (!is_dir(Browser::$storeScreenshotsAt)) {
            mkdir(Browser::$storeScreenshotsAt, $mode = 0777, true);
        }
    }

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless'
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()->setCapability(
            ChromeOptions::CAPABILITY, $options
        )
        );
    }
}
