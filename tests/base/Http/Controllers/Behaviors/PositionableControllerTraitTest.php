<?php

use Mockery as m;
use Ohio\Core\Base\Testing\CommonMocks;
use Ohio\Core\Base\Http\Controllers\Behaviors\PositionableControllerTrait;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Rutorika\Sortable\MorphToSortedMany;

class PositionableControllerTraitTest extends \PHPUnit_Framework_TestCase
{
    use CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\Base\Http\Controllers\Behaviors\PositionableControllerTrait::repositionEntity
     */
    public function test()
    {
        $controller = new PositionableControllerStub();

        $entityToMove = new PositionableChildModelStub(['id' => 3]);
        $entityInDesiredPosition = new PositionableChildModelStub(['id' => 1]);

        # moveAfter
        $collection = m::mock(Collection::class);
        $collection->shouldReceive('where')->once()->with('id', 3)->andReturnSelf();
        $collection->shouldReceive('first')->once()->andReturn($entityToMove);
        $collection->shouldReceive('where')->once()->with('id', 1)->andReturnSelf();
        $collection->shouldReceive('first')->once()->andReturn($entityInDesiredPosition);

        $relation = m::mock(MorphToSortedMany::class);
        $relation->shouldReceive('moveAfter')->once()->with($entityToMove, $entityInDesiredPosition)->andReturnNull();

        $request = new Request(['move' => 'after', 'position_entity_id' => 1]);

        $controller->repositionEntity($request, 3, $collection, $relation);

        # moveBefore
        $collection = m::mock(Collection::class);
        $collection->shouldReceive('where')->once()->with('id', 3)->andReturnSelf();
        $collection->shouldReceive('first')->once()->andReturn($entityToMove);
        $collection->shouldReceive('where')->once()->with('id', 1)->andReturnSelf();
        $collection->shouldReceive('first')->once()->andReturn($entityInDesiredPosition);

        $relation = m::mock(MorphToSortedMany::class);
        $relation->shouldReceive('moveBefore')->once()->with($entityToMove, $entityInDesiredPosition)->andReturnNull();

        $request = new Request(['move' => 'before', 'position_entity_id' => 3]);

        $controller->repositionEntity($request, 1, $collection, $relation);
    }

}

class PositionableChildModelStub
{
    public $id;

    public function __construct($attributes)
    {
        $this->id = array_get($attributes, 'id');
    }
}

class PositionableControllerStub extends Controller
{
    use PositionableControllerTrait;
}