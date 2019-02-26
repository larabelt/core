<?php namespace Tests\Belt\Core\Unit\Policies;

use Belt\Core\Form;
use Belt\Core\Policies\FormPolicy;
use Tests\Belt\Core;

class FormPolicyTest extends \Tests\Belt\Core\BeltTestCase
{

    use \Tests\Belt\Core\Base\CommonMocks;

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