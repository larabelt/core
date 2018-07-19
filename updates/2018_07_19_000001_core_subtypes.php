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

}