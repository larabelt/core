<?php namespace Tests\Belt\Core\Unit;

use Belt\Core\Behaviors\Paramable;
use Belt\Core\Behaviors\ParamableInterface;
use Belt\Core\Param;
use Tests\Belt\Core\BeltTestCase;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ParamTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Param::paramable
     * @covers \Belt\Core\Param::getConfig
     * @covers \Belt\Core\Param::config
     * @covers \Belt\Core\Param::setKeyAttribute
     * @covers \Belt\Core\Param::setValueAttribute
     * @covers \Belt\Core\Param::getValueAttribute
     * @covers \Belt\Core\Param::getTranslatableAttributes
     */
    public function test()
    {
        $param = factory(Param::class)->make(['']);

        # paramable
        $this->assertInstanceOf(MorphTo::class, $param->paramable());

        # setKeyAttribute
        $param->setKeyAttribute('FOO');
        $this->assertEquals('foo', $param->key);

        # setValueAttribute / getValueAttribute
        $param->setValueAttribute('TEST');
        $this->assertEquals('TEST', $param->value);
        $param->setValueAttribute('true');
        $this->assertTrue($param->value);
        $param->setValueAttribute('false');
        $this->assertFalse($param->value);

        # getConfig / config
        $param->paramable = new StubParamTestParamable();
        $this->assertEquals('square', $param->config('shape'));

        # getTranslatableAttributes
        $this->assertEquals('value', $param->getTranslatableAttributes());
    }

}

class StubParamTestParamable implements ParamableInterface
{
    use Paramable;

    public function getParamConfig()
    {
        return [
            'foo' => [
                'translatable' => true,
                'shape' => 'square',
            ]
        ];
    }
}