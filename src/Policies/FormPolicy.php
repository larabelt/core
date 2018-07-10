<?php

namespace Belt\Core\Policies;

use Belt;
use Cookie;
use Belt\Core\Form;
use Belt\Core\User;

/**
 * Class FormPolicy
 * @package Belt\Clip\Policies
 */
class FormPolicy extends \Belt\Core\Policies\BaseAdminPolicy
{

    /**
     * @param Form $form
     * @return bool
     */
    private function guidMatches(Form $form)
    {
        return $form->guid === Cookie::get('guid');
    }

    /**
     * Determine whether the user can view the object.
     *
     * @param  User $auth
     * @param  Form $arguments
     * @return mixed
     */
    public function view(User $auth, $arguments = null)
    {
        if (true === $this->guidMatches($arguments)) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the object.
     *
     * @param  User $auth
     * @param  Form $arguments
     * @return mixed
     */
    public function update(User $auth, $arguments = null)
    {
        if (true === $this->guidMatches($arguments)) {
            return true;
        }
    }
}