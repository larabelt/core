<?php namespace Tests\Belt\Core\Feature\Api;

use Tests\Belt\Core;

class ApiRolesTest extends \Tests\Belt\Core\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # index
        $response = $this->json('GET', '/api/v1/roles');
        $response->assertStatus(200);

        # store
        $response = $this->json('POST', '/api/v1/roles', ['name' => 'test']);
        $response->assertStatus(201);
        $roleID = array_get($response->json(), 'id');

        # show
        $response = $this->json('GET', "/api/v1/roles/$roleID");
        $response->assertStatus(200);

        # update
        $this->json('PUT', "/api/v1/roles/$roleID", ['title' => 'updated']);
        $response = $this->json('GET', "/api/v1/roles/$roleID");
        $response->assertJson(['title' => 'updated']);

        # delete
        $response = $this->json('DELETE', "/api/v1/roles/$roleID");
        $response->assertStatus(204);
        $response = $this->json('GET', "/api/v1/roles/$roleID");
        $response->assertStatus(404);
    }

}