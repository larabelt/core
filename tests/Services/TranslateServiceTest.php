<?php

use Mockery as m;

use Belt\Core\Index;
use Belt\Core\Services\IndexService;
use Belt\Core\Testing;
use Belt\Core\Team;
use Belt\Core\Facades\MorphFacade as Morph;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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
     * @covers \Belt\Core\Services\IndexService::__construct
     * @covers \Belt\Core\Services\IndexService::configPath
     * @covers \Belt\Core\Services\IndexService::active
     * @covers \Belt\Core\Services\IndexService::getLocale
     * @covers \Belt\Core\Services\IndexService::setLocale
     * @covers \Belt\Core\Services\IndexService::setLocaleCookie
     * @covers \Belt\Core\Services\IndexService::getLocaleCookie
     * @covers \Belt\Core\Services\IndexService::prefixUrls
     * @covers \Belt\Core\Services\IndexService::getLocaleFromRequest
     * @covers \Belt\Core\Services\IndexService::isAvailableLocale
     * @covers \Belt\Core\Services\IndexService::getAvailableLocales
     * @covers \Belt\Core\Services\IndexService::getAlternateLocale
     * @covers \Belt\Core\Services\IndexService::getAlternateLocales
     * @covers \Belt\Core\Services\IndexService::setTranslateObjects
     * @covers \Belt\Core\Services\IndexService::canTranslateObjects
     * @covers \Belt\Core\Services\IndexService::translate
     */
    public function test()
    {
        return;

        # construct
        $console = new Command();
        $service = new IndexService(['console' => $console]);
        $this->assertEquals($console, $service->getConsole());

        # item
        $team = factory(Team::class)->make(['id' => 123]);
        $service->setItem($team);
        $this->assertEquals($team, $service->getItem());

        # data
        $team = factory(Team::class)->make(['id' => 123]);
        $data = $service->setItem($team)->data();
        $this->assertEquals($team->name, array_get($data, 'name'));

        # getIndex
        $team = factory(Team::class)->make(['id' => 123]);
        $index = new Index(['indexable_type' => 'teams', 'indexable_id' => 123]);
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('query')->andReturnSelf();
        $qb->shouldReceive('firstOrCreate')->with([
            'indexable_type' => $team->getMorphClass(),
            'indexable_id' => $team->id,
        ])->andReturn($index);
        $service = m::mock(IndexService::class . '[instance]');
        $service->shouldReceive('instance')->andReturn($qb);
        $this->assertEquals($index, $service->setItem($team)->getIndex());

        # columns
        /* @todo mock Schema better so db isn't used */
        $columns = Schema::getColumnListing('index');
        Cache::shouldReceive('get')->with('index-columns')->andReturnNull();
        Cache::shouldReceive('put')->with('index-columns', $columns, 24 * 60)->andReturnNull();
        $this->assertEquals($columns, $service->columns());
    }

}