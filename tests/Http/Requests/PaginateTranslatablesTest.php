<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Http\Requests\PaginateTranslatables;
use Illuminate\Database\Eloquent\Builder;

class PaginateTranslatablesTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Requests\PaginateTranslatables::modifyQuery
     */
    public function test()
    {
        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('where')->once()->with('translatable_id', 1);
        $qbMock->shouldReceive('where')->once()->with('translatable_type', 'params');

        $paginateRequest = new PaginateTranslatables(['translatable_id' => 1, 'translatable_type' => 'params']);

        # modifyQuery
        $paginateRequest->modifyQuery($qbMock);
    }

}