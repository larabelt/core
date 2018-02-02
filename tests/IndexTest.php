<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Index;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class IndexTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Index::indexable
     */
    public function test()
    {
        $index = new Index();

        $this->assertInstanceOf(MorphTo::class, $index->indexable());
    }

}