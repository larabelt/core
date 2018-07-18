<?php

use Belt\Core\Testing;
use Illuminate\Support\Facades\Queue;

class UsersFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {
        Queue::fake();

        $this->refreshDB();
        $this->actAsSuper();

        # index
        $response = $this->json('GET', '/api/v1/users');
        $response->assertStatus(200);

        # store
        $response = $this->json('POST', '/api/v1/users', [
            'email' => 'test@test.com',
            'first_name' => 'test',
            'last_name' => 'user',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['email' => 'test@test.com']);
        $userID = array_get($response->json(), 'id');

        # show
        $response = $this->json('GET', "/api/v1/users/$userID");
        $response->assertStatus(200);

        # update
        $this->json('PUT', "/api/v1/users/$userID", ['email' => 'updated@test.com']);
        $response = $this->json('GET', "/api/v1/users/$userID");
        $response->assertJson(['email' => 'updated@test.com']);

        # delete
        $response = $this->json('DELETE', "/api/v1/users/$userID");
        $response->assertStatus(204);
        $response = $this->json('GET', "/api/v1/users/$userID");
        $response->assertStatus(404);
    }

}