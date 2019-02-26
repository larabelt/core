<?php namespace Tests\Belt\Core\Unit;

use Belt\Core\Form;
use Tests\Belt\Core\BeltTestCase;

class FormTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Form::__toString
     * @covers \Belt\Core\Form::configPath
     * @covers \Belt\Core\Form::extension
     * @covers \Belt\Core\Form::data
     * @covers \Belt\Core\Form::__get
     */
    public function test()
    {
        app()['config']->set('belt.subtypes.forms.test.extension', FormTestExtension::class);

        $form = new Form(['subtype' => 'test']);

        # toString
        $form->token = 'test';
        $this->assertEquals('test', $form->__toString());

        # configPath
        $this->assertEquals('belt.subtypes.forms.test', $form->configPath());

        # extension
        $this->assertInstanceOf(FormTestExtension::class, $form->extension());

        # data
        $this->assertNull($form->data(null));
        $form->data = ['foo' => 'bar'];
        $this->assertEquals('bar', $form->data('foo'));
    }

}

class FormTestExtension extends \Belt\Core\Forms\BaseForm
{

}