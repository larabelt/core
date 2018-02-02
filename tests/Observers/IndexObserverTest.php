<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Jobs\UpdateIndexRecord;
use Belt\Core\Services\IndexService;
use Belt\Core\Observers\IndexObserver;
use Illuminate\Support\Facades\Queue;

class IndexObserverTest extends Testing\BeltTestCase
{

    public function setUp()
    {
        parent::setUp();
        Queue::fake();
        IndexService::enable();
        IndexObserverStub::unguard();
    }

    public function tearDown()
    {
        m::close();
        IndexService::disable();
    }

    /**
     * @covers \Belt\Core\Observers\IndexObserver::saved
     */
    public function testSaved()
    {
        $item = new IndexObserverStub(['id' => 123]);
        (new IndexObserver())->saved($item);
        Queue::assertPushed(UpdateIndexRecord::class, function ($job) use ($item) {
            return $job->id === 123;
        });
    }

    /**
     * @covers \Belt\Core\Observers\IndexObserver::deleted
     */
    public function testDeleting()
    {
        $item = new IndexObserverStub(['id' => 123]);
        (new IndexObserver())->deleted($item);
        Queue::assertPushed(UpdateIndexRecord::class, function ($job) use ($item) {
            return $job->id === 123;
        });
    }

}

class IndexObserverStub extends Testing\BaseModelStub
{

}