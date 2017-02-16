<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Param;

class ParamTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Param::setKeyAttribute
     * @covers \Belt\Core\Param::setValueAttribute
     */
    public function test()
    {
        $param = factory(Param::class)->make();
        $param->setKeyAttribute('TEST');
        $param->setValueAttribute('TEST');

        $this->assertEquals('test', $param->key);
        $this->assertEquals('TEST', $param->value);
    }

}