<?php

namespace Tests\Belt\Core;

use Belt\Core\User;
use Tests\Belt\Core\Base\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Session\Store;
use Tests\CreatesApplication;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NullSessionHandler;

/**
 * Class BeltTestCase
 * @package Tests\Belt\Core
 */
abstract class BeltTestCase extends TestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Update db config. Adding this to avoid errors. ENV values in phpunit.xml aren't passing through.
     *
     * @todo this seems like a hack. get config to work and remove this.
     */
    public function setUp()
    {
        parent::setUp();

        $this->refreshDB();

        $this->disableI18n();
    }

    /**
     * @throws \Exception
     */
    public function exceptionNotThrown()
    {
        throw new \Exception('Expected Exception Was Not Thrown, So Throwing This One Instead.');
    }

    /**
     * Auth as super user
     */
    public function actAsSuper()
    {
        User::unguard();
        $super = factory(User::class)->make(['is_super' => true]);
        $this->actingAs($super);
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

    /**
     * @param string $name
     * @return Store
     */
    public function getTestSession($name = 'test')
    {
        return new Store($name, new NullSessionHandler());
    }

    /**
     * Set config to disable internationalization
     */
    public function disableI18n()
    {
        app()['config']->set('app.locale', 'en');
        app()['config']->set('app.fallback_locale', 'en');
        app()['config']->set('belt.core.translate.locales', []);
    }

    /**
     * Set config to enable internationalization
     */
    public function enableI18n()
    {
        app()['config']->set('app.locale', 'en_US');
        app()['config']->set('app.fallback_locale', 'en_US');
        app()['config']->set('belt.core.translate.prefix-urls', true);
        app()['config']->set('belt.core.translate.locales', [
            ['code' => 'en_US', 'label' => 'English'],
            ['code' => 'es_ES', 'label' => 'Spanish'],
        ]);
    }
}
