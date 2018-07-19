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
        $this->move();
    }

    public function move()
    {
        $old_path = config_path('belt/templates');
        $new_path = config_path('belt/subtypes');

        if (file_exists($old_path)) {
            rename($old_path, $new_path);
            $this->info("rename config/belt/templates to config/belt/subtypes");
        }
    }

}