<?php
namespace Ohio\Core\Helpers;

use Illuminate\Filesystem\FilesystemManager;

class OhioHelper
{
    public function __toString()
    {
        return '';
    }

    public function uses($providerClass)
    {
        $providerList = array_keys(app()->getLoadedProviders());

        if (in_array($providerClass, $providerList)) {
            return true;
        }

        foreach ($providerList as $provider) {
            $spaces = explode('\\', $provider);
            if ($spaces[0] == 'Ohio') {
                if (str_slug($spaces[1]) == $providerClass) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public static function baseDisk()
    {
        app()['config']->set('filesystems.disks.base', ['driver' => 'local', 'root' => base_path()]);

        return (new FilesystemManager(app()))->disk('base');
    }

}