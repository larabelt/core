<?php

use Belt\Core\Testing;
use Belt\Core\WorkRequest;
use Belt\Core\Observers\WorkRequestObserver;
use Illuminate\Support\Facades\Queue;

class WorkRequestObserverTest extends Testing\BeltTestCase
{

    /**
     * @covers \Belt\Core\Observers\WorkRequestObserver::saving
     */
    public function testSaving()
    {
        $workRequest = new WorkRequest();
        $this->assertNull($workRequest->place);
        (new WorkRequestObserver())->saving($workRequest);
        $this->assertNotNull($workRequest->place);
    }

}