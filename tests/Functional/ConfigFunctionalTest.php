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
            'key1' => 'value1',
            'key2' => 'value2',
        ]);

        Route::get('one/two/config/test/{any?}', ConfigController::class . '@show');

        $response = $this->json('GET', '/one/two/config/test/key1');

        $response->assertStatus(200);
        $this->assertEquals('value1', $response->json());
    }

}