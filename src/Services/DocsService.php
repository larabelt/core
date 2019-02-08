<?php

namespace Belt\Core\Services;

use Belt, View;
use Matrix\Exception;

class DocsService
{

    use Belt\Core\Behaviors\HasConfig;
    use Belt\Core\Behaviors\HasDisk;

    /**
     * @var string
     */
    protected $configPath = 'belt.docs';

    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $rawPath;

    /**
     * @var string
     */
    protected $publishedDocPath;

    /**
     * @var string
     */
    protected $publishedAssetPath;

    /**
     * DocsService constructor.
     */
    public function __construct()
    {
        $this->rawPath = $this->config('paths.raw', 'resources/docs/raw');
        $this->publishedDocPath = $this->config('paths.doc_published', 'resources/docs/published');
        $this->publishedAssetPath = $this->config('paths.asset_published', 'storage/app/public/docs');
    }

    /**
     * @param $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @param bool $stripped
     * @return mixed|string
     */
    public function getVersion($stripped = false)
    {
        return $stripped ? str_replace('.', '', $this->version) : $this->version;
    }

    /**
     * @param $version
     * @throws \Exception
     */
    public function generate($version = null)
    {
        $version = $version ?: belt()->version(2);

        $this->setVersion($version);

        if (!$this->getVersion()) {
            throw new \Exception('version required');
        }

        $this->disk()->deleteDirectory($this->publishedDocPath);
        $this->disk()->deleteDirectory($this->publishedAssetPath);

        foreach ($this->disk()->allFiles($this->rawPath) as $raw_path) {
            if (str_contains(basename($raw_path), '-md.blade.php')) {
                $this->publishMDFile($raw_path);
            } else {
                $this->publishAsset($raw_path);
            }
        }
    }

    /**
     * @param $src
     */
    public function publishMDFile($src)
    {
        $replacements = [
            $this->rawPath => $this->publishedDocPath,
            '-md.blade.php' => '.md',
            $this->getVersion(true) => $this->getVersion(false),
        ];

        $target = str_replace(array_keys($replacements), array_values($replacements), $src);

        $this->disk()->put($target, $this->renderMD($src));
    }

    /**
     * @param $src
     */
    public function publishAsset($src)
    {
        $target = str_replace($this->rawPath, $this->publishedAssetPath, $src);

        $this->disk()->copy($src, $target);
    }

    /**
     * @param $path
     * @return mixed|string
     */
    public function renderMD($path)
    {
        $replacements = [
            "resources/docs/raw/{$this->getVersion(true)}/" => '',
            '.blade.php' => '',
            '/' => '.',
            $this->getVersion(true) => $this->getVersion(false),
        ];

        $view = str_replace(array_keys($replacements), array_values($replacements), $path);
        $view = sprintf('belt-docs::%s.%s', $this->getVersion(true), $view);

        return View::make($view, ['version' => $this->getVersion()])->render();
    }

}