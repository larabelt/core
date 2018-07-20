<?php

use Belt\Core\Services\Update\BaseUpdate;

/**
 * Class UpdateService
 * @package Belt\Core\Services
 */
class BeltUpdateTestFoo extends BaseUpdate
{
    /**
     *
     */
    public function up()
    {
        return 'foo';
    }

}