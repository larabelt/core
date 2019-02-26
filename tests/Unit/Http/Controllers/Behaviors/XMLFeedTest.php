<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Controllers\Behaviors\XMLFeed;
use Belt\Core\Team;
use Tests\Belt\Core\BeltTestCase;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Mockery as m;

class XMLFeedTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Controllers\Behaviors\XMLFeed::xmlContent
     * @covers \Belt\Core\Http\Controllers\Behaviors\XMLFeed::xmlResponse
     */
    public function test()
    {

        # xmlContent
        $teams = factory(Team::class, 2)->make();
        $controller = new XMLFeedControllerStub();
        $xml = $controller->xmlContent('belt-core::teams.rss.index', [
            'title' => 'Teams',
            'items' => $teams,
        ]);
        $this->assertTrue(str_contains($xml, '<?xml version'));

        # xmlResponse
        $response = $controller->xmlResponse($xml);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('text/xml', $response->headers->get('content-type'));

    }

}

class XMLFeedControllerStub extends Controller
{
    use XMLFeed;
}