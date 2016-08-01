<?php
namespace Ohio\Core\Role;

use Ohio\Core\Base\BasePresenter;

class RolePresenter extends BasePresenter
{

    /**
     * Prepare data to present
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RoleTransformer();
    }


}