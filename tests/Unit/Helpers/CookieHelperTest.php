<?php namespace Tests\Belt\Core\Unit\Helpers;

use Belt\Core\Helpers\CookieHelper;
use Belt\Core\Tests\BeltTestCase;

class CookieHelperTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Helpers\CookieHelper::getJson
     */
    public function testconfig()
    {
        # no value set
        $this->app['request']->cookies->set('foo', '');
        $this->assertNull(CookieHelper::getJson('foo', 'bar.place'));

        # non-json value set
        $this->app['request']->cookies->set('foo', 'bar');
        $this->assertEquals('bar', CookieHelper::getJson('foo', 'bar.place'));

        # json value set
        $this->app['request']->cookies->set('foo', json_encode(['bar' => ['place' => 'world']]));
        $this->assertEquals(['place' => 'world'], CookieHelper::getJson('foo', 'bar'));
        $this->assertEquals('world', CookieHelper::getJson('foo', 'bar.place'));
    }
}
