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

class IndexServiceTest extends Testing\BeltTestCase
{
    public function setUp()
    {
        parent::setUp();
        Team::unguard();
        Index::unguard();
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Services\IndexService::__construct
     * @covers \Belt\Core\Services\IndexService::enable
     * @covers \Belt\Core\Services\IndexService::disable
     * @covers \Belt\Core\Services\IndexService::isEnabled
     * @covers \Belt\Core\Services\IndexService::setItem
     * @covers \Belt\Core\Services\IndexService::getItem
     * @covers \Belt\Core\Services\IndexService::data
     * @covers \Belt\Core\Services\IndexService::columns
     * @covers \Belt\Core\Services\IndexService::getIndex
     * @covers \Belt\Core\Services\IndexService::upsert
     * @covers \Belt\Core\Services\IndexService::mergeSchema
     * @covers \Belt\Core\Services\IndexService::batchUpsert
     */
    public function test()
    {
        # construct
        $console = new Command();
        $service = new IndexService(['console' => $console]);
        $this->assertEquals($console, $service->getConsole());

        # enable / disable / isEnabled
        IndexService::disable();
        $this->assertEquals(false, IndexService::isEnabled());
        IndexService::enable();
        $this->assertEquals(true, IndexService::isEnabled());

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

    /**
     * @covers \Belt\Core\Services\IndexService::mergeSchema
     * @todo mock Schema better so db isn't used
     */
    public function testMergeSchema()
    {
        $this->refreshDB();
        $service = new IndexService();
        $this->assertFalse(in_array('starts_at', $service->columns(true)));
        Morph::shouldReceive('type2Table')->with('alerts')->andReturn('alerts');
        $service->mergeSchema('alerts');
        $this->assertTrue(in_array('starts_at', $service->columns(true)));
    }

    /**
     * @covers \Belt\Core\Services\IndexService::batchUpsert
     */
    public function testBatchUpsert()
    {
        $items = new Collection([factory(Team::class)->make()]);
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('take')->with(20)->andReturnSelf();
        $qb->shouldReceive('orderBy')->with('id')->andReturnSelf();
        $qb->shouldReceive('offset')->withAnyArgs()->andReturnSelf();
        $qb->shouldReceive('get')->andReturn($items);

        Morph::shouldReceive('type2QB')->with('alerts')->andReturn($qb);

        $service = m::mock(IndexService::class . '[upsert]');
        $service->shouldReceive('upsert')->andReturnSelf();
        $service->batchUpsert('alerts');
    }

    /**
     * @covers \Belt\Core\Services\IndexService::delete
     */
    public function testDelete()
    {
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('query')->andReturnSelf();
        $qb->shouldReceive('where')->with('indexable_id', 123)->andReturnSelf();
        $qb->shouldReceive('where')->with('indexable_type', 'teams')->andReturnSelf();
        $qb->shouldReceive('delete')->andReturnSelf();
        $service = m::mock(IndexService::class . '[instance]');
        $service->shouldReceive('instance')->andReturn($qb);
        $service->delete(123, 'teams');
    }

    /**
     * @covers \Belt\Core\Services\IndexService::upsert
     */
    public function testUpsert()
    {
        $data = ['foo' => 'bar'];
        $team = factory(Team::class)->make(['id' => 123]);
        $index = m::mock(Index::class);
        $index->shouldReceive('save')->andReturnSelf();
        $index->shouldReceive('setAttribute')->with('foo', 'bar')->andReturnSelf();
        $service = m::mock(IndexService::class . '[getIndex,data]');
        $service->shouldReceive('data')->andReturn($data);
        $service->shouldReceive('getIndex')->andReturn($index);
        $service->setItem($team)->upsert();
    }

}