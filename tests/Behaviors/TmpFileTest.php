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
     * covers \Belt\Core\Behaviors\TmpFile::createTmpFile
     * covers \Belt\Core\Behaviors\TmpFile::getTmpFileUri
     * covers \Belt\Core\Behaviors\TmpFile::getTmpFileContents
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
    }

}

class TmpFileStub
{
    use TmpFile;
}