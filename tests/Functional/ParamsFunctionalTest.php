<?php

use Ohio\Core\Testing;

class ParamsFunctionalTest extends Testing\OhioTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # index
        $response = $this->json('GET', '/api/v1/sections/1/params');
        $response->assertStatus(200);

        # store
        $response = $this->json('POST', '/api/v1/sections/1/params', [
            'key' => 'class',
            'value' => 'active',
        ]);
        $response->assertStatus(201);
        $paramID = array_get($response->json(), 'id');

        # show
        $response = $this->json('GET', "/api/v1/sections/1/params/$paramID");
        $response->assertStatus(200);

        # update
        $this->json('PUT', "/api/v1/sections/1/params/$paramID", [
            'value' => 'updated'
        ]);
        $response = $this->json('GET', "/api/v1/sections/1/params/$paramID");
        $response->assertJson(['value' => 'updated']);

        # delete
        $response = $this->json('DELETE', "/api/v1/sections/1/params/$paramID");
        $response->assertStatus(204);
        $response = $this->json('GET', "/api/v1/sections/1/params/$paramID");
        $response->assertStatus(404);
    }

}