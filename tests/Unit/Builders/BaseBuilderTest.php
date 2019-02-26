<?php namespace Tests\Belt\Core\Unit\Builders;

use Belt\Core\Behaviors;
use Belt\Core\Builders\BaseBuilder;
use Tests\Belt\Core\BeltTestCase;
use Mockery as m;

class BaseBuilderTest extends BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Builders\BaseBuilder::__construct
     */
    public function test()
    {
        # __construct
        $builder = new BaseBuilderTestStub(new BaseBuilderTestStubItem());
        $this->assertInstanceOf(BaseBuilderTestStubItem::class, $builder->item);

        $this->assertEquals('foo', $builder->build());
    }

}

class BaseBuilderTestStubItem implements Behaviors\IncludesSubtypesInterface
{
    use Behaviors\IncludesSubtypes;
}

class BaseBuilderTestStub extends BaseBuilder
{
    public function build()
    {
        return 'foo';
    }
}