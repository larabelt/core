<?php
namespace Ohio\Core\Model\UserRole\Domain;

use Ohio\Core\Domain\BasePresenter;

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