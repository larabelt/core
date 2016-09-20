<?php

use Mockery as m;
use Ohio\Core\Base\BaseModel;

class BaseModelTest extends \PHPUnit_Framework_TestCase
{

//    public function tearDown()
//    {
//        m::close();
//        Illuminate\Database\Eloquent\Model::unsetEventDispatcher();
//        Carbon\Carbon::resetToStringFormat();
//    }

    public function test__toString()
    {
        $model = new BaseModel;
        $this->assertEquals('', $model->__toString());
        $model->id = 1;
        $this->assertEquals('1', $model->__toString());
    }
}
