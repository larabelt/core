<?php

namespace Tests\Services;

use Mockery as m;
use Belt\Core\Services\DocsService;
use Belt\Core\Testing\BeltTestCase;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\View;

class DocsServiceTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        app()['config']->set('belt.docs', [
            'paths' => [
                'raw' => 'raw/test',
                'doc_published' => 'published/docs/test',
                'asset_published' => 'published/assets/test',
            ]
        ]);
    }

    /**
     * @covers \Belt\Core\Services\DocsService::__construct
     * @covers \Belt\Core\Services\DocsService::setVersion
     * @covers \Belt\Core\Services\DocsService::getVersion
     * @covers \Belt\Core\Services\DocsService::generate
     * @covers \Belt\Core\Services\DocsService::publishMDFile
     * @covers \Belt\Core\Services\DocsService::publishAsset
     * @covers \Belt\Core\Services\DocsService::renderMD
     */
    public function test()
    {
        # construct
        $service = new DocsService();

        # set/get version
        $service->setVersion('2.0');
        $this->assertEquals('2.0', $service->getVersion(false));
        $this->assertEquals('20', $service->getVersion(true));

        # publishMDFile
        $disk = m::mock(FilesystemAdapter::class);
        $disk->shouldReceive('put')->once()->with('published/docs/test/20/index.md', '**foo**');
        $service = m::mock(DocsService::class . '[renderMD]');
        $service->setDisk($disk);
        $service->shouldReceive('renderMD')->once()->with('raw/test/20/index-md.blade.php')->andReturn('**foo**');
        $service->publishMDFile('raw/test/20/index-md.blade.php');

        # publishAsset
        $disk = m::mock(FilesystemAdapter::class);
        $disk->shouldReceive('copy')->once()->with('raw/test/foo.css', 'published/assets/test/foo.css');
        $service = new DocsService();
        $service->setDisk($disk);
        $service->publishAsset('raw/test/foo.css');

        # renderMD
        $service = new DocsService();
        $service->setVersion('20');
        View::shouldReceive('make')->once()->with('belt-docs::20.foo.index-md', ['version' => $service->getVersion()])->andReturnSelf();
        View::shouldReceive('render')->once();
        $service->renderMD('raw/test/20/foo/index-md.blade.php');

        # generate
        $disk = m::mock(FilesystemAdapter::class);
        $disk->shouldReceive('deleteDirectory')->once()->with('published/docs/test');
        $disk->shouldReceive('deleteDirectory')->once()->with('published/assets/test');
        $disk->shouldReceive('allFiles')->once()->with('raw/test')->andReturn([
            'foo.css',
            'foo-md.blade.php',
        ]);
        $service = m::mock(DocsService::class . '[publishMDFile,publishAsset]');
        $service->setDisk($disk);
        $service->shouldReceive('publishMDFile')->once()->with('foo-md.blade.php');
        $service->shouldReceive('publishAsset')->once()->with('foo.css');
        $service->generate('2.0');
    }

}
