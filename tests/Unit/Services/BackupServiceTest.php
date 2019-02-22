<?php namespace Tests\Belt\Core\Unit\Services;

use Belt\Core\Jobs\BackupDatabase;
use Belt\Core\Services\BackupService;
use Belt\Core\Tests;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Mockery as m;
use Spatie\DbDumper\DbDumper;

class BackupServiceTest extends Tests\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function setUp()
    {
        parent::setUp();

        app()['config']->set('database.connections.foo', [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'test',
            'username' => 'testuser',
            'password' => 'secret',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);


    }

    /**
     * @covers \Belt\Core\Services\BackupService::configPath
     * @covers \Belt\Core\Services\BackupService::setGroupOptions
     * @covers \Belt\Core\Services\BackupService::option
     * @covers \Belt\Core\Services\BackupService::getDatabaseConfig
     * @covers \Belt\Core\Services\BackupService::disk
     * @covers \Belt\Core\Services\BackupService::run
     * @covers \Belt\Core\Services\BackupService::backup
     * @covers \Belt\Core\Services\BackupService::getDumper
     * @covers \Belt\Core\Services\BackupService::getDumperMysql
     */
    public function test()
    {
        app()['config']->set('belt.core.backup', [
            'defaults' => [
                'connection' => 'foo',
                'disk' => 'local',
                'relPath' => 'backups',
                'expires' => '15 days',
            ],
            'groups' => [
                'foo' => [
                    'disk' => 's3',
                    'include' => ['blocks', 'users'],
                    'relPath' => function () {
                        return sprintf('foo/%s/backups', date('Y'));
                    },
                    'filename' => function () {
                        return sprintf('foo-%s.sql', date('m'));
                    }
                ],
                'bar' => [
                    'exclude' => ['blocks', 'users'],
                ],
                'jacked-up' => [
                    'connection' => 'missing',
                ],
            ],
        ]);

        $service = new BackupService();

        # configPath
        $this->assertNotNull($service->configPath());

        # setGroupOptions
        # option
        $service->setGroupOptions('foo');
        $this->assertEquals('foo', $service->option('name'));
        $this->assertEquals(sprintf('foo/%s/backups', date('Y')), $service->option('relPath'));
        $this->assertEquals(sprintf('foo-%s.sql', date('m')), $service->option('filename'));
        $this->assertEquals('15 days', $service->option('expires'));
        $this->assertEquals('s3', $service->option('disk'));

        # getDatabaseConfig
        $this->assertEquals('secret', $service->getDatabaseConfig('password'));
        $this->assertEquals('foo', $service->getDatabaseConfig('missing', 'foo'));

        # run
        \Queue::fake();
        $service->run();
        Queue::assertPushed(BackupDatabase::class, function ($job) {
            return $job->key == 'foo';
        });

        # disk
        $disk = m::mock(FilesystemAdapter::class);
        Storage::shouldReceive('disk')->with('foo')->andReturn($disk);
        $this->assertEquals($disk, $service->disk('foo'));

        # getDumper
        # getDumperMysql
        $dumper = $service->getDumper();
        $this->assertInstanceOf(DbDumper::class, $dumper);

        # getDumper (exclude)
        $service->setGroupOptions('bar');
        $dumper = $service->getDumper();
        $this->assertInstanceOf(DbDumper::class, $dumper);

        # getDumper (exception)
        $service->setGroupOptions('jacked-up');
        try {
            $service->getDumper();
            $this->exceptionNotThrown();
        } catch (\Exception $e) {

        }
    }

    /**
     * @covers \Belt\Core\Services\BackupService::backup
     */
    public function testBackup()
    {

        app()['config']->set('belt.core.backup', [
            'defaults' => [
                'connection' => 'foo',
                'disk' => 's3',
            ],
            'groups' => [
                'foo' => [
                    'relPath' => 'foo',
                    'filename' => 'bar.sql',
                ],
            ],
        ]);

        // dumper
        $dumper = m::mock(DbDumper::class);
        $dumper->shouldReceive('dumpToFile')->andReturnSelf();

        // disk
        $disk = m::mock(FilesystemAdapter::class);
        $disk->shouldReceive('put')->with('foo/bar.sql', '');
        Storage::shouldReceive('disk')->with('s3')->andReturn($disk);

        // service
        $service = m::mock(BackupService::class . '[getDumper,purge]');
        $service->shouldReceive('getDumper')->andReturn($dumper);
        $service->shouldReceive('purge')->andReturnSelf();

        $service->backup('foo');
    }

    /**
     * @covers \Belt\Core\Services\BackupService::purge
     */
    public function testPurge()
    {
        app()['config']->set('belt.core.backup', [
            'defaults' => [
                'connection' => 'foo',
                'disk' => 'local',
                'expires' => '15 days',
            ],
            'groups' => [
                'foo' => [

                ],
            ],
        ]);

        $files = [
            'foo1.sql',
            'foo2.sql',
            'foo3.sql',
        ];

        $service = new BackupService();
        $service->setGroupOptions('foo');

        // disk
        $disk = m::mock(FilesystemAdapter::class);
        $disk->shouldReceive('files')->andReturn($files);
        $disk->shouldReceive('getTimestamp')->with($files[0])->andReturn(strtotime('-20 days'));
        $disk->shouldReceive('getTimestamp')->with($files[1])->andReturn(strtotime('-5 days'));
        $disk->shouldReceive('getTimestamp')->with($files[2])->andReturn(strtotime('-1 days'));
        $disk->shouldReceive('delete')->once()->with($files[0])->andReturnSelf();
        Storage::shouldReceive('disk')->with('local')->andReturn($disk);

        $service->purge();
    }

}