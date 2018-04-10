<?php

use Belt\Core\Testing;
use Belt\Core\Param;

class ParamablesFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # store
        $response = $this->json('POST', '/api/v1/sections/1/params', [
            'key' => 'class',
            'value' => 'active',
        ]);
        $response->assertStatus(201);
        $paramID = array_get($response->json(), 'id');

        # index
        $response = $this->json('GET', '/api/v1/sections/1/params');
        $response->assertStatus(200);

        # show
        $response = $this->json('GET', "/api/v1/sections/2/params/$paramID");
        $response->assertStatus(404);
        $response = $this->json('GET', "/api/v1/sections/1/params/$paramID");
        $response->assertStatus(200);

        # show (with key, not id)
        $response = $this->json('GET', "/api/v1/sections/1/params/class");
        $response->assertStatus(200);

        # update
        $this->json('PUT', "/api/v1/sections/1/params/$paramID", [
            'value' => 'updated'
        ]);
        $response = $this->json('GET', "/api/v1/sections/1/params/$paramID");
        $response->assertJson(['value' => 'updated']);

        # copy
        $old = Param::find($paramID);
        $new = Param::copy($old, ['paramable_id' => 1]);
        $response = $this->json('GET', "/api/v1/sections/1/params/$new->id");
        $response->assertStatus(200);

        # delete
        $response = $this->json('DELETE', "/api/v1/sections/1/params/$paramID");
        $response->assertStatus(204);
        $response = $this->json('GET', "/api/v1/sections/1/params/$paramID");
        $response->assertStatus(404);
    }

}