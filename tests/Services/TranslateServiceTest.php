<?php

use Mockery as m;
use Belt\Core\Services\TranslateService;
use Belt\Core\Services\AutoTranslate\BaseAutoTranslate;
use Belt\Core\Testing;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie as CookieObject;

class TranslateServiceTest extends Testing\BeltTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->enableI18n();
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Services\TranslateService::__construct
     * @covers \Belt\Core\Services\TranslateService::configPath
     * @covers \Belt\Core\Services\TranslateService::getLocale
     * @covers \Belt\Core\Services\TranslateService::setLocale
     * @covers \Belt\Core\Services\TranslateService::setLocaleCookie
     * @covers \Belt\Core\Services\TranslateService::getLocaleCookie
     * @covers \Belt\Core\Services\TranslateService::prefixUrls
     * @covers \Belt\Core\Services\TranslateService::getLocaleFromRequest
     * @covers \Belt\Core\Services\TranslateService::isAvailableLocale
     * @covers \Belt\Core\Services\TranslateService::getAvailableLocales
     * @covers \Belt\Core\Services\TranslateService::getAlternateLocale
     * @covers \Belt\Core\Services\TranslateService::getAlternateLocales
     * @covers \Belt\Core\Services\TranslateService::setTranslateObjects
     * @covers \Belt\Core\Services\TranslateService::canTranslateObjects
     * @covers \Belt\Core\Services\TranslateService::translate
     */
    public function test()
    {
        $this->enableI18n();

        $code = function ($locale) {
            return array_get($locale, 'code');
        };

        $service = new TranslateService();

        # configPath
        $this->assertNotEmpty($service->configPath());

        # getAvailableLocales
        $locale = array_first($service->getAvailableLocales(), function ($locale) {
            return array_get($locale, 'code') == 'es_ES';
        });
        $this->assertEquals('es_ES', $code($locale));

        # isAvailableLocale
        $this->assertEquals('es_ES', $code($service->isAvailableLocale('es_ES')));
        $this->assertNull($service->isAvailableLocale('foo'));

        # setLocale / getLocale
        $service->setLocale('es_ES');
        $this->assertEquals('es_ES', $service->getLocale());
        $service->setLocale('en_US');
        $this->assertEquals('en_US', $service->getLocale());

        # getLocaleFromRequest
        app()['config']->set('belt.core.translate.prefix-urls', false);
        $service = new TranslateService();
        $this->assertEquals('es_ES', $service->getLocaleFromRequest(new Request(['locale' => 'es_ES'])));
        $this->assertNull($service->getLocaleFromRequest(new Request(['locale' => 'foo'])));

        app()['config']->set('belt.core.translate.prefix-urls', true);
        $service = new TranslateService();
        $request = new Request();
        $request->server->set('REQUEST_URI', 'es_ES/foo/bar');
        $this->assertEquals('es_ES', $service->getLocaleFromRequest($request));
        $request = new Request();
        $request->server->set('REQUEST_URI', 'foo/foo/bar');
        $this->assertNull($service->getLocaleFromRequest($request));

        # getAlternateLocale
        $service->setLocale('es_ES');
        $this->assertEquals('es_ES', $service->getAlternateLocale());
        $service->setLocale('en_US');
        $this->assertNull($service->getAlternateLocale());

        # getAlternateLocales
        $locales = array_where($service->getAvailableLocales(), function ($locale) {
            return array_get($locale, 'code') == 'es_ES';
        });
        $this->assertEquals(array_values($locales), array_values($service->getAlternateLocales()));

        # setTranslateObjects / canTranslateObjects
        TranslateService::setTranslateObjects(false);
        $this->assertFalse(TranslateService::canTranslateObjects());
        TranslateService::setTranslateObjects(true);
        $this->assertTrue(TranslateService::canTranslateObjects());

        # setLocaleCookie
        $cookie = m::mock(CookieObject::class);
        Cookie::shouldReceive('make')->once()->with('locale', 'es_ES', 86400 * 365, null, null, false, false)->andReturn($cookie);
        Cookie::shouldReceive('queue')->once()->with($cookie);
        $service->setLocaleCookie('es_ES');

        # getLocaleCookie
        $cookie = m::mock(CookieObject::class);
        $cookie->shouldReceive('getValue')->andReturn('es_ES');
        Cookie::shouldReceive('queued')->once()->with('locale')->andReturn($cookie);
        $this->assertEquals('es_ES', $service->getLocaleCookie());

        Cookie::shouldReceive('queued')->once()->with('locale')->andReturnNull();
        //Cookie::shouldReceive('get')->once()->with('locale')->andReturn('es_ES');
        $this->app['request']->cookies->set('locale', 'es_ES');
        $this->assertEquals('es_ES', $service->getLocaleCookie());

        # translate
        app()['config']->set('belt.core.translate.auto-translate.driver', StubTranslateServiceTestAutoTranslate::class);
        $service = new TranslateService();
        $this->assertEquals('translated foo from en_US to es_ES', $service->translate('foo', 'es_ES'));


    }

}

class StubTranslateServiceTestAutoTranslate extends BaseAutoTranslate
{

    /**
     * @param $text
     * @param $target_locale
     * @param $source_locale
     * @return \Aws\Result
     */
    public function translate($text, $target_locale, $source_locale)
    {
        return sprintf('translated %s from %s to %s', $text, $source_locale, $target_locale);
    }
}