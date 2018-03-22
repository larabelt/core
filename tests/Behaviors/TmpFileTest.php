<?php

use Mockery as m;
use Belt\Core\Behaviors\TmpFile;
use Belt\Core\Testing\BeltTestCase;

class TmpFileTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * covers \Belt\Core\Behaviors\TmpFile::__destruct
     * covers \Belt\Core\Behaviors\TmpFile::createTmpFile
     * covers \Belt\Core\Behaviors\TmpFile::getTmpFileUri
     * covers \Belt\Core\Behaviors\TmpFile::getTmpFileContents
     * covers \Belt\Core\Behaviors\TmpFile::destroyTmpFile
     */
    public function test()
    {


        $stub = new TmpFileStub();

        # createTmpFile
        $this->assertNull($stub->tmpFile);
        $stub->createTmpFile();
        $this->assertNotNull($stub->tmpFile);

        # getTmpFileUri
        $this->assertNotNull($stub->getTmpFileUri());

        # getTmpFileContents
        $this->assertNotNull($stub->getTmpFileContents());

        # __destruct
        # destroyTmpFile
        $stub->destroyTmpFile();
        $this->assertNull($stub->tmpFile);
    }

}

class TmpFileStub
{
    use TmpFile;
}