<?php

namespace Belt\Core\Observers;

use Belt, Cookie;
use Belt\Core\Form;

class FormObserver
{
    /**
     * Listen to the Model creating $item.
     *
     * @param Form $form
     */
    public function creating(Form $form)
    {
        $form->token = str_random(16);
    }

    /**
     * Listen to the Model saving $item.
     *
     * @param Form $form
     */
    public function saving(Form $form)
    {
        $form->guid = $form->guid ?: Cookie::get('guid');
    }

}