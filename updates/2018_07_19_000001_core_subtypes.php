<?php

use Illuminate\Support\Facades\DB;
use Belt\Core\Services\Update\BaseUpdate;
use Belt\Core\Role;

/**
 * Class UpdateService
 * @package Belt\Core\Services
 */
class BeltUpdateCoreSubtypes extends BaseUpdate
{
    public function up()
    {
        $this->info(sprintf('subtypes'));

    }

    public function move()
    {
        //$tmpPath = $this->option('new-path', 'templates-tmp');
        $tmpPath = config_path('belt/templates');

        dump($tmpPath);


        return;
        if ($tmpPath && file_exists($tmpPath)) {
            $targetPath = $this->option('target-path', 'templates');
            $targetPath = config_path('belt/' . $targetPath);
            if ($targetPath) {
                if (file_exists($targetPath)) {
                    $archivedPath = "$targetPath-archived";
                    rename($targetPath, $archivedPath);
                    $this->info("moved existing path to: $archivedPath");
                }
                rename($tmpPath, $targetPath);
                $this->info("moved new path to: $targetPath");
            }
        }
    }

}