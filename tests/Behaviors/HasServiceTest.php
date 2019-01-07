<?php

use Mockery as m;
use Belt\Core\Behaviors\HasService;
use Belt\Core\Testing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Filesystem\Filesystem;

class HasServiceTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Behaviors\HasService::service
     */
    public function test()
    {
        //$stub = new HasServiceTestStub();
        //$this->assertInstanceOf(Filesystem::class, $stub->service());
    }

}

class HasServiceTestStub extends Model
{
    use HasService;

}