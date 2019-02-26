<?php namespace Tests\Belt\Core\Unit\Behaviors;

use Belt\Core\Behaviors\HasDisk;
use Tests\Belt\Core;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Mockery as m;

class HasDiskTest extends \Tests\Belt\Core\BeltTestCase
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