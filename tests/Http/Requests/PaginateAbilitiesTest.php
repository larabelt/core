<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Http\Requests\PaginateAbilities;
use Illuminate\Database\Eloquent\Builder;

class PaginateAbilitiesTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Requests\PaginateAbilities::modifyQuery
     */
    public function test()
    {
        # modifyQuery (w/entityType)
        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('where')->once()->with('entity_id', 1);
        $paginateRequest = new PaginateAbilities(['entity_id' => 1]);
        $paginateRequest->modifyQuery($qbMock);

        # modifyQuery (wo/entityType)
        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('whereNull')->once()->with('entity_id');
        $paginateRequest = new PaginateAbilities();
        $paginateRequest->modifyQuery($qbMock);
    }

}