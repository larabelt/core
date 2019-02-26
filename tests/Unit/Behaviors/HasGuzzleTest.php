<?php namespace Tests\Belt\Core\Unit\Behaviors;

use Belt\Core\Behaviors\HasGuzzle;
use Tests\Belt\Core;
use Illuminate\Database\Eloquent\Model;
use Mockery as m;

class HasGuzzleTest extends \Tests\Belt\Core\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Behaviors\HasGuzzle::guzzle
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