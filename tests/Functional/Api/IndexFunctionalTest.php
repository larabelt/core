<?php

use Belt\Core\Testing;

class IndexFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # index
        $response = $this->json('GET', '/api/v1/index');
        $response->assertStatus(200);
    }

}