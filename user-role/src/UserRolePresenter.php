<?php
namespace Ohio\Core\UserRole;

use Ohio\Core\Base\BasePresenter;

class UserRolePresenter extends BasePresenter
{

    /**
     * Prepare data to present
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UserRoleTransformer();
    }


}