<?php

use Mockery as m;
use Belt\Core\Behaviors\HasGuzzle;
use Belt\Core\Testing;
use Illuminate\Database\Eloquent\Model;

class HasGuzzleTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * covers \Belt\Core\Behaviors\HasGuzzle::guzzle
     */
    public function test()
    {
        $stub = new HasGuzzleTestStub();
        $this->assertInstanceOf(\GuzzleHttp\Client::class, $stub->guzzle());
    }

}

class HasGuzzleTestStub extends Model
{
    use HasGuzzle;

}