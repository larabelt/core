<?php namespace Tests\Belt\Core\Unit\Resources;

use Belt\Core\Resources\BaseParamGroup;
use Belt\Core\Resources\BaseResource;
use Belt\Core\Resources\Params\Text;
use Belt\Core\Resources\Traits\HasParamGroups;
use Belt\Core\Resources\Traits\HasParams;
use Belt\Core\Tests\BeltTestCase;
use Illuminate\Support\Collection;

class ResourcesTraitsHasParamGroupsTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Resources\Traits\HasParamGroups::setParamGroups
     * @covers \Belt\Core\Resources\Traits\HasParamGroups::getParamGroups
     * @covers \Belt\Core\Resources\Traits\HasParamGroups::pushParamGroup
     * @covers \Belt\Core\Resources\Traits\HasParamGroups::makeParamGroups
     */
    public function test()
    {
        # makeParamGroups
        $resource = StubResourcesTraitsHasParamGroupsTest::make();
        $hasParamGroup1 = false;
        $hasParamGroup2 = false;
        foreach ($resource->getParamGroups() as $paramGroup) {
            if ($paramGroup->getKey() == 'key1') {
                $hasParamGroup1 = true;
            }
            if ($paramGroup->getKey() == 'group_text2') {
                $hasParamGroup2 = true;
            }
        }
        $this->assertTrue($hasParamGroup1);
        $this->assertTrue($hasParamGroup2);

        # set/get paramGroups
        $resource = StubResourcesTraitsHasParamGroupsTest::make('foo');
        $paramGroups = new Collection();
        $resource->setParamGroups($paramGroups);
        $this->assertEquals($paramGroups, $resource->getParamGroups());

        # push param group
        $resource = StubResourcesTraitsHasParamGroupsTest::make('foo');
        $paramGroupResource = StubResourcesTraitsHasParamGroupsTestParamGroup::make();
        $resource->pushParamGroup($paramGroupResource);
        $hasParam = false;
        foreach ($resource->getParamGroups() as $paramGroup) {
            if (get_class($paramGroup) == StubResourcesTraitsHasParamGroupsTestParamGroup::class) {
                $hasParam = true;
            }
        }
        $this->assertTrue($hasParam);
    }

}

class StubResourcesTraitsHasParamGroupsTest extends BaseResource
{
    use HasParams;
    use HasParamGroups;

    public function setup()
    {
        $this->makeParams();
        $this->makeParamGroups();
    }

    /**
     * @return array
     */
    public function params()
    {
        return [
            StubResourcesTraitsHasParamGroupsTestParamGroup::make(),
            StubResourcesTraitsHasParamGroupsTestParam2::make('text2'),
        ];
    }
}

class StubResourcesTraitsHasParamGroupsTestParam extends Text
{
    protected $group = 'group_text1';
    protected $description = 'description1';
}

class StubResourcesTraitsHasParamGroupsTestParam2 extends Text
{
    protected $group = 'group_text2';
    protected $description = 'description2';
}

class StubResourcesTraitsHasParamGroupsTestParamGroup extends BaseParamGroup
{
    use HasParamGroups;

    protected $key = 'key1';
    protected $prefix = 'prefix1';

    /**
     * @return array
     */
    public function paramGroups()
    {
        return [
            StubResourcesTraitsHasParamGroupsTestParam::make('text1'),
        ];
    }
}