<?php namespace Tests\Belt\Core\Feature\Api;

use Tests\Belt\Core;
use Silber\Bouncer\BouncerFacade;

class ApiAccessTest extends \Tests\Belt\Core\BeltTestCase
{

    public function test()
    {
        BouncerFacade::dontCache();

        $this->refreshDB();
        $this->actAsSuper();

        # super user can attach roles
        $response = $this->json('GET', '/api/v1/users/1/access/attach/roles');
        $this->assertEquals('true', $response->content());
        $response->assertStatus(200);

        # non-super user cannot attach roles
        $response = $this->json('GET', '/api/v1/users/2/access/attach/roles');
        $this->assertEquals('false', $response->content());
        $response->assertStatus(200);

    }

}