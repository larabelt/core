<?php

namespace Belt\Core\Behaviors;

use Belt;

/**
 * Class TmpFile
 * @package Belt\Core\Services
 */
trait TmpFile
{
    /**
     * @var resource|bool a file handle
     */
    public $tmpFile;

    /**
     * MoveService destructor.
     */
    function __destruct()
    {
        $this->destroyTmpFile();
    }

    /**
     * @param
     */
    public function createTmpFile()
    {
        $this->destroyTmpFile();

        $this->tmpFile = tmpfile();

        //fwrite($this->tmpFile, '');
    }

    /**
     * Get uri of tmp file
     *
     * @return mixed
     */
    public function getTmpFileUri()
    {
        return array_get(stream_get_meta_data($this->tmpFile), 'uri');
    }

    /**
     * Get contents of tmp file
     *
     * @return bool|string
     */
    public function getTmpFileContents()
    {
        return file_get_contents($this->getTmpFileUri());
    }

    /**
     * Destroy tmp file
     */
    public function destroyTmpFile()
    {
        if ($this->tmpFile) {
            fclose($this->tmpFile); // this removes the file
        }
    }

}