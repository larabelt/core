<?php

use Belt\Core\Helpers\UrlHelper;
use Belt\Core\Testing\BeltTestCase;

class UrlHelperTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Helpers\UrlHelper::staticUrl
     */
    public function test()
    {
        # no static url
        putenv("APP_STATIC_URL=");
        $this->assertEquals(sprintf('%s/test', $this->baseUrl), UrlHelper::staticUrl('test'));

        # static url
        putenv("APP_STATIC_URL=http://static.local.domain");
        $this->assertEquals('http://static.local.domain/test', UrlHelper::staticUrl('test'));

    }
}
