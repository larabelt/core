<?php

use Mockery as m;
use Belt\Core\Testing\CommonMocks;
use Belt\Core\Http\Controllers\Behaviors\Positionable;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Rutorika\Sortable\MorphToSortedMany;

class PositionableTest extends \PHPUnit_Framework_TestCase
{
    use CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Controllers\Behaviors\Positionable::repositionHasManyThrough
     * @covers \Belt\Core\Http\Controllers\Behaviors\Positionable::reposition
     */
    public function test()
    {
        $controller = new PositionableControllerStub();

        $entityToMove = new PositionableChildModelStub(['id' => 3]);
        $entityInDesiredPosition = new PositionableChildModelStub(['id' => 1]);

        # repositionHasManyThrough::moveAfter
        $collection = m::mock(Collection::class);
        $collection->shouldReceive('where')->once()->with('id', 3)->andReturnSelf();
        $collection->shouldReceive('first')->once()->andReturn($entityToMove);
        $collection->shouldReceive('where')->once()->with('id', 1)->andReturnSelf();
        $collection->shouldReceive('first')->once()->andReturn($entityInDesiredPosition);
        $relation = m::mock(MorphToSortedMany::class);
        $relation->shouldReceive('moveAfter')->once()->with($entityToMove, $entityInDesiredPosition)->andReturnNull();
        $request = new Request(['move' => 'after', 'position_entity_id' => 1]);
        $controller->repositionHasManyThrough($request, 3, $collection, $relation);

        # repositionHasManyThrough::moveBefore
        $collection = m::mock(Collection::class);
        $collection->shouldReceive('where')->once()->with('id', 3)->andReturnSelf();
        $collection->shouldReceive('first')->once()->andReturn($entityToMove);
        $collection->shouldReceive('where')->once()->with('id', 1)->andReturnSelf();
        $collection->shouldReceive('first')->once()->andReturn($entityInDesiredPosition);
        $relation = m::mock(MorphToSortedMany::class);
        $relation->shouldReceive('moveBefore')->once()->with($entityToMove, $entityInDesiredPosition)->andReturnNull();
        $request = new Request(['move' => 'before', 'position_entity_id' => 3]);
        $controller->repositionHasManyThrough($request, 1, $collection, $relation);

        # reposition::moveAfter
        $entityToMove = m::mock(PositionableChildModelStub::class);
        $entityToMove->shouldReceive('query')->once()->andReturnSelf();
        $entityToMove->shouldReceive('where')->once()->with('id', 1)->andReturnSelf();
        $entityToMove->shouldReceive('first')->once()->andReturn($entityInDesiredPosition);
        $entityToMove->shouldReceive('moveAfter')->once()->with($entityInDesiredPosition);
        $request = new Request(['move' => 'after', 'position_entity_id' => 1]);
        $controller->reposition($request, $entityToMove);

        # reposition::moveBefore
        $entityToMove = m::mock(PositionableChildModelStub::class);
        $entityToMove->shouldReceive('query')->once()->andReturnSelf();
        $entityToMove->shouldReceive('where')->once()->with('id', 1)->andReturnSelf();
        $entityToMove->shouldReceive('first')->once()->andReturn($entityInDesiredPosition);
        $entityToMove->shouldReceive('moveBefore')->once()->with($entityInDesiredPosition);
        $request = new Request(['move' => 'before', 'position_entity_id' => 1]);
        $controller->reposition($request, $entityToMove);
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
    use Positionable;
}