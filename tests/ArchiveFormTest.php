<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Form;

class FormTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Form::configPath
     * @covers \Belt\Core\Form::template
     * @covers \Belt\Core\Form::data
     * @covers \Belt\Core\Form::__get
     */
    public function test()
    {
        app()['config']->set('belt.forms.test.template', FormTestTemplate::class);

        $form = new Form();
        $form->config_key = 'test';

        # configPath
        $this->assertEquals('belt.forms.test', $form->configPath());

        # template
        $this->assertInstanceOf(FormTestTemplate::class, $form->template());

        # data
        $form->data = ['foo' => 'bar'];
        $this->assertEquals('bar', $form->data('foo'));
        $this->assertNull($form->data('missing'));
    }

}

class FormTestTemplate extends \Belt\Core\Forms\BaseForm
{

}