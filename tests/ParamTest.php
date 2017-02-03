<?php

use Ohio\Core\Testing\OhioTestCase;
use Ohio\Core\Param;

class ParamTest extends OhioTestCase
{
    /**
     * @covers \Ohio\Core\Param::setKeyAttribute
     * @covers \Ohio\Core\Param::setValueAttribute
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