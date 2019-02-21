<?php namespace Tests\Belt\Core\Unit\Behaviors;

use Belt\Core\Behaviors\TmpFile;
use Belt\Core\Tests\BeltTestCase;
use Mockery as m;

class TmpFileTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * covers \Belt\Core\Behaviors\TmpFile::createTmpFile
     * covers \Belt\Core\Behaviors\TmpFile::getTmpFileUri
     * covers \Belt\Core\Behaviors\TmpFile::getTmpFileContents
     */
    public function test()
    {


        $stub = new TmpFileStub();

        # createTmpFile
        $this->assertNull($stub->tmpFile);
        $stub->createTmpFile('test');
        $this->assertNotNull($stub->tmpFile);

        # getTmpFileUri
        $this->assertNotNull($stub->getTmpFileUri());

        # getTmpFileContents
        $this->assertNotNull($stub->getTmpFileContents());
        $this->assertEquals('test', $stub->getTmpFileContents());
    }

}

class TmpFileStub
{
    use TmpFile;
}