<?php namespace Tests\Belt\Core\Unit\Behaviors;

use Belt\Core\Behaviors\HasDriver;
use Belt\Core\Tests\BeltTestCase;
use Illuminate\Database\Eloquent\Model;

class HasDriverTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Behaviors\HasDriver::defaultDriverClass
     * @covers \Belt\Core\Behaviors\HasDriver::driverClass
     * @covers \Belt\Core\Behaviors\HasDriver::adapter
     * @covers \Belt\Core\Behaviors\HasDriver::initAdapter
     */
    public function test()
    {
        # driverClass (missing)
        $stub = new HasDriverTestStub();
        try {
            $stub->driverClass();
            $this->exceptionNotThrown();
        } catch (\Exception $e) {

        }

        # driverClass
        $stub = new HasDriverTestStub2();
        $this->assertEquals(HasDriverTestStubDriver::class, $stub->driverClass());

        # adapter
        $this->assertInstanceOf(HasDriverTestStubDriver::class, $stub->adapter());
    }

}

class HasDriverTestStubDriver
{


}

class HasDriverTestStub extends Model
{
    use HasDriver;

    /**
     * {@inheritdoc}
     */
    public function configPath()
    {
        return 'test.HasDriverTestStub';
    }

    public function defaultDriverClass()
    {
        return null;
    }

}

class HasDriverTestStub2 extends HasDriverTestStub
{
    public function configPath()
    {
        return 'test.HasDriverTestStub2';
    }

    public function defaultDriverClass()
    {
        return HasDriverTestStubDriver::class;
    }

}