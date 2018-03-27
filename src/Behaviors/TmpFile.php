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
     * @param
     */
    public function createTmpFile($contents = null)
    {
        $this->tmpFile = tmpfile();

        if ($contents) {
            fwrite($this->tmpFile, $contents);
        }
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

}