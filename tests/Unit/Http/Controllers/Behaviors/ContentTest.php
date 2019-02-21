<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Content\Page;
use Belt\Core\Http\Controllers\Behaviors\Content;
use Belt\Core\Tests\BeltTestCase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Controller;
use Mockery as m;

class ContentTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Controllers\Behaviors\Content::contentQuery
     * @covers \Belt\Core\Http\Controllers\Behaviors\Content::contentPage
     */
    public function test()
    {

        # contentQuery
        $controller = new ContentControllerStub();
        $this->assertInstanceOf(Builder::class, $controller->contentQuery());

        # contentPage
        $controller = new ContentControllerStub2();
        $page = $controller->contentPage('foo');
        $this->assertEquals('Foo Bar', $page->name);

    }

}

class ContentControllerStub extends Controller
{
    use Content;
}

class ContentControllerStub2 extends Controller
{
    use Content;

    /**
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function contentQuery()
    {
        $page = factory(Page::class)->make(['name' => 'Foo Bar']);

        $qb = m::mock(Builder::class);
        $qb->shouldReceive('where')->with('is_active', true)->andReturnSelf();
        $qb->shouldReceive('sluggish')->with('foo')->andReturnSelf();
        $qb->shouldReceive('first')->andReturn($page);

        return $qb;
    }
}