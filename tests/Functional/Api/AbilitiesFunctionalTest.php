<?php

use Belt\Core\Testing;

class AbilitiesFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # index
        $response = $this->json('GET', '/api/v1/abilities');
        $response->assertStatus(200);

        # store
        $response = $this->json('POST', '/api/v1/abilities', [
            'name' => 'test',
            'entity_type' => 'users',
            'entity_id' => 1,
        ]);
        $response->assertStatus(201);
        $abilityID = array_get($response->json(), 'id');

        # show
        $response = $this->json('GET', "/api/v1/abilities/$abilityID");
        $response->assertStatus(200);

        # update
        $this->json('PUT', "/api/v1/abilities/$abilityID", ['title' => 'updated']);
        $response = $this->json('GET', "/api/v1/abilities/$abilityID");
        $response->assertJson(['title' => 'updated']);

        # delete
        $response = $this->json('DELETE', "/api/v1/abilities/$abilityID");
        $response->assertStatus(204);
        $response = $this->json('GET', "/api/v1/abilities/$abilityID");
        $response->assertStatus(404);
    }

}