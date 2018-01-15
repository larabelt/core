<?php

use Belt\Core\Testing;
use Illuminate\Support\Facades\Mail;

class ContactFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {

        $this->refreshDB();
        $this->actAsSuper();

        # missing email
        $post = [
            'name' => 'test user',
            'comments' => 'bla bla bla',
        ];
        $response = $this->json('POST', '/api/v1/contact', $post);
        $response->assertStatus(422);

        # default contact
        $post = [
            'email' => 'test@zym.me',
            'name' => 'test user',
            'comments' => 'bla bla bla',
        ];
        Mail::shouldReceive('to')->once()->andReturnSelf();
        Mail::shouldReceive('queue')->once()->andReturnSelf();
        $response = $this->json('POST', '/api/v1/contact', $post);
        $response->assertStatus(201);
    }

}