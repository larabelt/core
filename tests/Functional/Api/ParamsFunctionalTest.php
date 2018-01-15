<?php

use Belt\Core\Testing;
use Belt\Core\Param;

class ParamsFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # keys
        $response = $this->json('GET', '/api/v1/param-keys');
        $response->assertStatus(200);

        # values
        $response = $this->json('GET', '/api/v1/param-values?key=foo');
        $response->assertStatus(200);


    }

}