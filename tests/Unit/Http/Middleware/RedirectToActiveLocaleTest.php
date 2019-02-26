<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Facades\TranslateFacade as Translate;
use Belt\Core\Http\Middleware\RedirectToActiveLocale;
use Tests\Belt\Core\BeltTestCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Mockery as m;

class RedirectToActiveLocaleTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function setUp()
    {
        parent::setUp();
        $this->enableI18n();
    }

    private function getNextClosure()
    {
        $next = function ($request) {
            if ($request instanceof Request) {
                return true;
            }
            return false;
        };

        return $next;
    }

    /**
     * @covers \Belt\Core\Http\Middleware\RedirectToActiveLocale::handle
     */
    public function testCase1()
    {
        RedirectToActiveLocale::disable();
        $middleware = new RedirectToActiveLocale();
        $this->assertTrue($middleware->handle(new Request(), $this->getNextClosure()));
    }

    /**
     * @covers \Belt\Core\Http\Middleware\RedirectToActiveLocale::handle
     */
    public function testCase2()
    {
        RedirectToActiveLocale::enable();
        Translate::disable();
        $middleware = new RedirectToActiveLocale();
        $this->assertTrue($middleware->handle(new Request(), $this->getNextClosure()));
    }

    /**
     * @covers \Belt\Core\Http\Middleware\RedirectToActiveLocale::handle
     */
    public function testCase3()
    {
        RedirectToActiveLocale::enable();
        Translate::enable();
        $middleware = new RedirectToActiveLocale();
        $request = new Request();
        $request->setMethod('POST');
        $this->assertTrue($middleware->handle($request, $this->getNextClosure()));
    }

    /**
     * @covers \Belt\Core\Http\Middleware\RedirectToActiveLocale::handle
     */
    public function testCase4()
    {
        RedirectToActiveLocale::enable();
        Translate::enable();
        $middleware = new RedirectToActiveLocale();
        $this->assertTrue($middleware->handle(new Request(['locale' => 'es_ES']), $this->getNextClosure()));
    }

    /**
     * @covers \Belt\Core\Http\Middleware\RedirectToActiveLocale::handle
     */
    public function testCase5()
    {
        RedirectToActiveLocale::enable();

        Translate::shouldReceive('isEnabled')->andReturn(true);
        Translate::shouldReceive('getLocaleFromRequest')->andReturn(null);
        Translate::shouldReceive('getLocaleCookie')->andReturn(null);
        Translate::shouldReceive('getLocale')->andReturn('es_ES');

        $middleware = new RedirectToActiveLocale();
        $response = $middleware->handle(new Request(), $this->getNextClosure());
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertTrue(str_contains($response->getTargetUrl(), '/es_ES'));
    }


}