<?php

use Belt\Core\Testing;
use Belt\Core\Mail\ContactSubmitted;
use Illuminate\Support\Facades\Mail;

class ContactFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        $post = [
            'email' => 'test@zym.me',
            'name' => 'test user',
            'comments' => 'bla bla bla',
        ];

        Mail::shouldReceive('to')->once()->andReturnSelf();
        Mail::shouldReceive('send')->once();

        $response = $this->json('POST', '/api/v1/contact', $post);

        $response->assertStatus(201);
    }

}