<?php namespace Tests\Belt\Core\Feature\Api;

use Belt\Core\Tests;
use Silber\Bouncer\BouncerFacade;

class ApiPermissionsTest extends Tests\BeltTestCase
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
        $response->assertJsonFragment(['id' => 1]);

        # attach
        $response = $this->json('GET', '/api/v1/users/1/permissions/1');
        $response->assertStatus(200);

        # detach
        $response = $this->json('DELETE', "/api/v1/users/1/permissions/1");
        $response->assertStatus(204);
    }

}