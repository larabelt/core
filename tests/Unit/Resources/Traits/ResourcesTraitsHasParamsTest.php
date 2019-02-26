<?php namespace Tests\Belt\Core\Unit\Resources;

use Belt\Core\Resources\BaseParamGroup;
use Belt\Core\Resources\BaseResource;
use Belt\Core\Resources\Params\Text;
use Belt\Core\Resources\Traits\HasParams;
use Tests\Belt\Core\BeltTestCase;
use Illuminate\Support\Collection;

class ResourcesTraitsHasParamsTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Resources\Traits\HasParams::params
     * @covers \Belt\Core\Resources\Traits\HasParams::setParams
     * @covers \Belt\Core\Resources\Traits\HasParams::getParams
     * @covers \Belt\Core\Resources\Traits\HasParams::pushParam
     * @covers \Belt\Core\Resources\Traits\HasParams::makeParams
     * @covers \Belt\Core\Resources\Traits\HasParams::__makeParams
     */
    public function test()
    {
        $resource = StubResourcesTraitsHasParamsTest::make('foo');
        $params = new Collection();

        # params
        $this->assertEquals([], $resource->params());

        # set/get params
        $resource->setParams($params);
        $this->assertEquals($params, $resource->getParams());

        # push param
        $paramResource = StubResourcesTraitsHasParamsTestParam::make();
        $resource->pushParam($paramResource);
        $params = $resource->getParams();
        $hasParam = false;
        foreach ($params as $param) {
            if (get_class($param) == StubResourcesTraitsHasParamsTestParam::class) {
                $hasParam = true;
            }
        }
        $this->assertTrue($hasParam);

        # makeParams
        $resource = StubResourcesTraitsHasParamsTestParamGroup::make();
        $hasParam = false;
        foreach ($resource->getParams() as $param) {
            $array = $param->toArray();
            if (array_get($array, 'description') == 'description1') {
                $hasParam = true;
            }
        }
        $this->assertTrue($hasParam);

        $resource = StubResourcesTraitsHasParamsTestParamGroup2::make();
        $hasParam = false;
        foreach ($resource->getParams() as $param) {
            $array = $param->toArray();
            if (array_get($array, 'description') == 'description1') {
                $hasParam = true;
            }
        }
        $this->assertTrue($hasParam);
    }

}

class StubResourcesTraitsHasParamsTest extends BaseResource
{
    use HasParams;

    public function setup()
    {
        $this->makeParams();
    }
}

class StubResourcesTraitsHasParamsTestParam extends Text
{
    protected $description = 'description1';
}

class StubResourcesTraitsHasParamsTestParamGroup extends BaseParamGroup
{
    use HasParams;

    protected $key = 'key1';
    protected $prefix = 'prefix1';

    public function setup()
    {
        $this->makeParams();
    }

    /**
     * @return array
     */
    public function params()
    {
        return [
            StubResourcesTraitsHasParamsTestParam::make('text1'),
        ];
    }
}

class StubResourcesTraitsHasParamsTestParamGroup2 extends BaseParamGroup
{
    use HasParams;

    protected $key = 'key2';
    protected $prefix = 'prefix2';

    public function setup()
    {
        $this->makeParams();
    }

    /**
     * @return array
     */
    public function params()
    {
        return [
            StubResourcesTraitsHasParamsTestParamGroup::make(),
        ];
    }
}