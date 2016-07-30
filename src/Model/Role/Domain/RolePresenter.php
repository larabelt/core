<?php
namespace Ohio\Core\Model\Role\Domain;

use Ohio\Core\Domain\BasePresenter;

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