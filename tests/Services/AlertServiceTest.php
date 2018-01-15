<?php

use Mockery as m;

use Belt\Core\Alert;
use Belt\Core\Services\AlertService;
use Belt\Core\Testing;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class AlertServiceTest extends Testing\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Services\AlertService::init
     * @covers \Belt\Core\Services\AlertService::cache
     * @covers \Belt\Core\Services\AlertService::query
     */
    public function test()
    {
        # init
        Cache::shouldReceive('has')->with('alerts')->andReturn(false);
        $service = m::mock(AlertService::class . '[cache]');
        $service->shouldReceive('cache')->andReturn(true);
        $service->init();

        # query
        $service = new AlertService();
        $this->assertInstanceOf(Builder::class, $service->query());

        # cache
        Alert::unguard();
        $alerts = new Collection();
        $alerts->add(factory(Alert::class)->make(['id' => 3]));
        $alerts->add(factory(Alert::class)->make(['id' => 2]));

        $query = m::mock(Builder::class);
        $query->shouldReceive('active')->andReturnSelf();
        $query->shouldReceive('get')->andReturn($alerts);

        $service = m::mock(AlertService::class . '[query]');
        $service->shouldReceive('query')->andReturn($query);

        //$alerts = $alerts->keyBy('id');

        Cache::shouldReceive('put');

        $service->cache();

    }

}