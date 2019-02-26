<?php namespace Tests\Belt\Core\Unit\Commands;

use Belt\Core\Commands\TestCommand;
use Belt\Core\Facades\MorphFacade;
use Tests\Belt\Core\BeltTestCase;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\FilesystemAdapter;
use Mockery as m;

class TestCommandTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Commands\TestCommand::disk
     * @covers \Belt\Core\Commands\TestCommand::handle
     * @covers \Belt\Core\Commands\TestCommand::responses
     * @covers \Belt\Core\Commands\TestCommand::buildTestingDB
     */
    public function testHandle()
    {

        $cmd = new TestCommand();

        # disk
        $this->assertInstanceOf(Filesystem::class, $cmd->disk());

        # fire (option.env is testing)
        $disk = $this->mockDisk();

        # handle (action=db)
        $cmd = m::mock(TestCommand::class . '[argument,option,disk,call]');
        $cmd->shouldReceive('argument')->with('action')->andReturn('db');
        $cmd->shouldReceive('option')->with('types')->andReturn();
        $cmd->shouldReceive('disk')->andReturn($disk);
        $cmd->shouldReceive('call')->andReturn();
        $cmd->handle();

        # handle (action=responses)
        $cmd = m::mock(TestCommand::class . '[argument,option,warn]');
        $cmd->shouldReceive('argument')->with('action')->andReturn('responses');
        $cmd->shouldReceive('option')->with('types')->andReturn('pages');
        $cmd->shouldReceive('option')->with('subtypes')->andReturn('default');
        $cmd->shouldReceive('warn')->andReturn('warning');

        $items = collect([new TestCommandTestStub()]);

        $qb = m::mock(\Illuminate\Database\Eloquent\Builder::class);
        $qb->shouldReceive('whereIn')->with('subtype', ['default'])->andReturnSelf();
        $qb->shouldReceive('get')->andReturn($items);
        MorphFacade::shouldReceive('type2QB')->with('pages')->andReturn($qb);

        $cmd->handle();
    }

    /**
     * @covers \Belt\Core\Commands\TestCommand::responses
     */
    public function testHandle2()
    {

        # handle (action=responses with exception)
        $cmd = m::mock(TestCommand::class . '[argument,option,warn]');
        $cmd->shouldReceive('argument')->with('action')->andReturn('responses');
        $cmd->shouldReceive('option')->with('types')->andReturn('pages');
        $cmd->shouldReceive('option')->with('subtypes')->andReturn('default');
        $cmd->shouldReceive('warn')->andThrow(new \Exception());
        $items = collect([new TestCommandTestStub()]);
        $qb = m::mock(\Illuminate\Database\Eloquent\Builder::class);
        $qb->shouldReceive('whereIn')->with('subtype', ['default'])->andReturnSelf();
        $qb->shouldReceive('get')->andReturn($items);
        MorphFacade::shouldReceive('type2QB')->with('pages')->andReturn($qb);

        $cmd->handle();
    }

    private function mockDisk()
    {
        $disk = m::mock(FilesystemAdapter::class);
        $disk->shouldReceive('delete')->andReturn(true);
        $disk->shouldReceive('copy')->andReturn(true);

        $disk->shouldReceive('files')->andReturn([
            '/path/to/src/Seeder1',
            '/path/to/src/Seeder2',
            '/path/to/src/Seeder3',
        ]);

        return $disk;
    }

}

class TestCommandTestStub extends Model
{
    /**
     * TestCommandTestStub constructor.
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        static::unguard();
        $attributes['id'] = 1;
        $attributes['default_url'] = '/foo';
        $attributes['is_active'] = 0;
        parent::__construct($attributes);
    }

    /**
     * @return bool|void
     */
    public function save(array $options = [])
    {

    }
}
