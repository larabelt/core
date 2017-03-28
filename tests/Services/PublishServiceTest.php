<?php

use Mockery as m;

use Belt\Core\Services\PublishService;
use Belt\Core\PublishHistory;
use Belt\Core\Testing\BeltTestCase;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Schema;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class PublishServiceTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Services\PublishService::__construct
     * @covers \Belt\Core\Services\PublishService::setPublishHistoryTable
     * @covers \Belt\Core\Services\PublishService::disk
     * @covers \Belt\Core\Services\PublishService::getFilePublishHistory
     * @covers \Belt\Core\Services\PublishService::putFile
     * @covers \Belt\Core\Services\PublishService::createFile
     * @covers \Belt\Core\Services\PublishService::replaceFile
     * @covers \Belt\Core\Services\PublishService::evalFile
     * @covers \Belt\Core\Services\PublishService::publishDir
     * @covers \Belt\Core\Services\PublishService::publish
     */
    public function test()
    {

        # __construct
        # setPublishHistoryTable
        $schemaClass = m::mock('overload:' . Schema::class);
        $schemaClass->shouldReceive('hasTable')->andReturn(false);
        $schemaClass->shouldReceive('create')->andReturn(true);

        $force = true;
        $dirs = [1, 2, 3];
        $files = [4, 5, 6];

        $service = new PublishService([
            'force' => $force,
            'dirs' => $dirs,
            'files' => $files,
        ]);

        $this->assertEquals($service->force, $force);
        $this->assertEquals($service->dirs, $dirs);
        $this->assertEquals($service->files, $files);

        # disk
        $this->assertInstanceOf(Filesystem::class, $service->disk());

        # getFilePublishHistory
        $publishHistory = m::mock(PublishHistory::class);
        $publishHistory->shouldReceive('firstOrCreate')->andReturn($this->mockHistory());
        $service->publishHistory = $publishHistory;
        $history = $service->getFilePublishHistory('/src');

        # mock disk
        $service->disk = $this->mockDisk();
        $service->disk->shouldReceive('exists')->andReturn(false);

        # putFile
        $service->putFile('/src', '/target', $history);

        # createFile
        $this->assertEquals(count($service->created), 0);
        $service->createFile('/src', '/target', $history);
        $this->assertEquals(count($service->created), 1);

        # replaceFile
        $this->assertEquals(count($service->modified), 0);
        $service->replaceFile('/src', '/target', $history);
        $this->assertEquals(count($service->modified), 1);

        # evalFile (file does not exist)
        $service->evalFile('/src', '/target');

        # evalFile (force == true)
        $history = $this->mockHistory();
        $service = $this->serviceMock($history);
        $service->disk = $this->mockDisk();
        $service->force = true;
        $this->assertEquals(count($service->modified), 0);
        $service->evalFile('/src', '/existing-target');
        $this->assertEquals(count($service->modified), 1);

        # evalFile (history->hash is null)
        $history = $this->mockHistory(null);
        $service = $this->serviceMock($history);
        $service->disk = $this->mockDisk();
        $this->assertEquals(count($service->ignored), 0);
        $service->evalFile('/src', '/existing-target');
        $this->assertEquals(count($service->ignored), 1);

        # evalFile (history->hash != target hash)
        $history = $this->mockHistory('different contents');
        $service = $this->serviceMock($history);
        $service->disk = $this->mockDisk();
        $this->assertEquals(count($service->ignored), 0);
        $service->evalFile('/src', '/existing-target');
        $this->assertEquals(count($service->ignored), 1);

        # evalFile (source hash != target hash)
        $history = $this->mockHistory('target contents');
        $service = $this->serviceMock($history);
        $service->disk = $this->mockDisk();
        $this->assertEquals(count($service->modified), 0);
        $service->evalFile('/updated-src', '/existing-target');
        $this->assertEquals(count($service->modified), 1);

        # evalFile (source hash == target hash)
        $history = $this->mockHistory('target contents');
        $service = $this->serviceMock($history);
        $service->disk = $this->mockDisk();
        $this->assertEquals(count($service->modified), 0);
        $service->evalFile('/unchanged-src', '/existing-target');
        $this->assertEquals(count($service->modified), 0);

        # publishDir
        $history = $this->mockHistory();
        $service = $this->serviceMock($history);
        $service->disk = $this->mockDisk();
        $service->force = true;
        $this->assertEquals(count($service->modified), 0);
        $service->publishDir('/path/to/src', '/path/to/target');
        $this->assertEquals(count($service->modified), 3);

        # publish
        $history = $this->mockHistory();
        $service = $this->serviceMock($history);
        $service->disk = $this->mockDisk();
        $service->force = true;
        $service->dirs = ['/path/to/src' => '/path/to/target'];
        $this->assertEquals(count($service->modified), 0);
        $service->publish();
        $this->assertEquals(count($service->modified), 3);


    }

    /**
     * @covers \Belt\Core\Services\PublishService::update
     */
    public function testUpdate()
    {
        $disk = m::mock(Filesystem::class);
        $disk->shouldReceive('get')->with('valid')->andReturn('contents');
        $disk->shouldReceive('get')->with('invalid')->andThrow(new \Exception());

        $history1 = m::mock(PublishHistory::class);
        $history1->shouldReceive('getAttribute')->with('path')->andReturn('valid');
        $history1->shouldReceive('delete')->andReturn();
        $history1->shouldReceive('update')->andReturn();

        $history2 = m::mock(PublishHistory::class);
        $history2->shouldReceive('getAttribute')->with('path')->andReturn('invalid');
        $history2->shouldReceive('delete')->andReturn();
        $history2->shouldReceive('update')->andReturn();

        $histories = new \Illuminate\Support\Collection();
        $histories->push($history1);
        $histories->push($history2);

        $qb = m::mock(Builder::class);
        $qb->shouldReceive('all')->andReturn($histories);

        $service = m::mock(PublishService::class . '[setPublishHistoryTable]');
        $service->disk = $disk;
        $service->publishHistory = $qb;
        $service->shouldReceive('setPublishHistoryTable')->andReturnNull();

        $service->update();
    }

    private function mockDisk()
    {
        $disk = m::mock(FilesystemAdapter::class);
        $disk->shouldReceive('put')->andReturn(true);
        $disk->shouldReceive('get')->with('/src')->andReturn('source contents');
        $disk->shouldReceive('get')->with('/unchanged-src')->andReturn('target contents');
        $disk->shouldReceive('get')->with('/updated-src')->andReturn('updated contents');
        $disk->shouldReceive('get')->with('/existing-target')->andReturn('target contents');
        $disk->shouldReceive('exists')->with('/target')->andReturn(false);
        $disk->shouldReceive('exists')->with('/existing-target')->andReturn(true);

        $disk->shouldReceive('allFiles')->with('/path/to/src')->andReturn([
            '/path/to/src/one',
            '/path/to/src/two',
            '/path/to/src/three',
        ]);

        $disk->shouldReceive('exists')->with('/path/to/src/one')->andReturn(true);
        $disk->shouldReceive('exists')->with('/path/to/src/two')->andReturn(true);
        $disk->shouldReceive('exists')->with('/path/to/src/three')->andReturn(true);
        $disk->shouldReceive('get')->with('/path/to/src/one')->andReturn('source contents');
        $disk->shouldReceive('get')->with('/path/to/src/two')->andReturn('source contents');
        $disk->shouldReceive('get')->with('/path/to/src/three')->andReturn('source contents');

        $disk->shouldReceive('exists')->with('/path/to/target/one')->andReturn(true);
        $disk->shouldReceive('exists')->with('/path/to/target/two')->andReturn(true);
        $disk->shouldReceive('exists')->with('/path/to/target/three')->andReturn(true);
        $disk->shouldReceive('get')->with('/path/to/target/one')->andReturn('source contents');
        $disk->shouldReceive('get')->with('/path/to/target/two')->andReturn('source contents');
        $disk->shouldReceive('get')->with('/path/to/target/three')->andReturn('source contents');

        return $disk;
    }

    private function mockHistory($contents = 'source contents')
    {
        $history = $this->getMockBuilder(PublishHistory::class)
            ->setMethods(['update'])
            ->getMock();

        $history->expects($this->any())->method('update')->willReturn(true);

        $history->hash = $contents ? md5($contents) : null;

        return $history;
    }

    private function serviceMock($history = null)
    {
        $service = $this->getMockBuilder(PublishService::class)
            ->setMethods(['getFilePublishHistory'])
            ->getMock();

        if ($history) {
            $service->expects($this->any())->method('getFilePublishHistory')->willReturn($history);
        }

        return $service;
    }


}
