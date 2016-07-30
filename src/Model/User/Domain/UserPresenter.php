<?php
namespace Ohio\Core\Model\User\Domain;

use Ohio\Core\Domain\BasePresenter;

class UserPresenter extends BasePresenter
{

    /**
     * Prepare data to present
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UserTransformer();
    }


}