<?php

use Belt\Core\Testing;
use Silber\Bouncer\BouncerFacade;

class PermissionsFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {
        BouncerFacade::dontCache();

        $this->refreshDB();
        $this->actAsSuper();

        # index
        $response = $this->json('GET', '/api/v1/users/1/permissions');
        $response->assertStatus(200);

        # attach
        $response = $this->json('POST', '/api/v1/users/1/permissions', [
            'ability_id' => 1,
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['id']);

        # attach
        $response = $this->json('GET', '/api/v1/users/1/permissions/1');
        $response->assertStatus(200);

        # detach
        $response = $this->json('DELETE', "/api/v1/users/1/permissions/1");
        $response->assertStatus(204);
    }

}