<?php

use Belt\Core\Services\Update\BaseUpdate;

/**
 * Class UpdateService
 * @package Belt\Core\Services
 */
class BeltUpdateSubtypes extends BaseUpdate
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