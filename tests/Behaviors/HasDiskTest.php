<?php

use Mockery as m;
use Belt\Core\Behaviors\HasDisk;
use Belt\Core\Testing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Filesystem\Filesystem;

class HasDiskTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Behaviors\HasDisk::disk
     */
    public function test()
    {
        $stub = new HasDiskTestStub();
        $this->assertInstanceOf(Filesystem::class, $stub->disk());
    }

}

class HasDiskTestStub extends Model
{
    use HasDisk;

}