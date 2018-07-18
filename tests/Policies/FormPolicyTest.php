<?php

use Belt\Core\Form;
use Belt\Core\Testing;
use Belt\Core\Policies\FormPolicy;

class FormPolicyTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    /**
     * @covers \Belt\Core\Policies\FormPolicy::guidMatches
     * @covers \Belt\Core\Policies\FormPolicy::view
     * @covers \Belt\Core\Policies\FormPolicy::update
     */
    public function test()
    {
        $user = $this->getUser();
        $this->app['request']->cookies->set('guid', 'foo');

        Form::unguard();
        $form1 = new Form(['guid' => 'foo']);
        $form2 = new Form(['guid' => 'bar']);

        $policy = new FormPolicy();

        # view
        $this->assertTrue($policy->view($user, $form1));
        $this->assertNotTrue($policy->view($user, $form2));

        # update
        $this->assertTrue($policy->update($user, $form1));
        $this->assertNotTrue($policy->update($user, $form2));
    }

}