<?php

use Belt\Core\Helpers\UrlHelper;
use Belt\Core\Testing\BeltTestCase;

class UrlHelperTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Helpers\UrlHelper::staticUrl
     * @covers \Belt\Core\Helpers\UrlHelper::normalize
     * @covers \Belt\Core\Helpers\UrlHelper::exists
     */
    public function test()
    {
        # no static url
        putenv("APP_STATIC_URL=");
        $this->assertEquals(sprintf('%s/test', $this->baseUrl), UrlHelper::staticUrl('test'));

        # static url
        putenv("APP_STATIC_URL=http://static.local.domain");
        $this->assertEquals('http://static.local.domain/test', UrlHelper::staticUrl('test'));

        # normalize
        $this->assertEquals('/foo/bar', UrlHelper::normalize('foo/bar/'));
        $this->assertEquals('http://foo.bar', UrlHelper::normalize('http://foo.bar/'));

        # exists
        $this->assertFalse(UrlHelper::exists('foo'));
        $this->assertFalse(UrlHelper::exists('http://foo'));
        $this->assertTrue(UrlHelper::exists('http://google.com'));
    }
}
