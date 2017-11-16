<?php

use Belt\Core\Testing;
use Belt\Core\Http\Controllers\Api\ConfigController;

class ConfigFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        app()['config']->set('test', [
            'foo' => 'bar',
            'other' => [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
        ]);

        $routes = Route::getRoutes();
        $catchAllRoute = $routes->getByAction('Belt\Content\Http\Controllers\CatchAllController@web');
        $catchAllRoute->setUri('something-else-so-catchall-does-not-happen');

        Route::get('/one/two/config/test/{any?}', ConfigController::class . '@show');

        $response = $this->json('GET', '/one/two/config/test/foo');
        $response->assertStatus(200);
        $this->assertEquals('bar', $response->json());

        $response = $this->json('GET', '/one/two/config/test', ['key' => 'other.key1']);
        $response->assertStatus(200);
        $this->assertEquals('value1', $response->json());
    }

}