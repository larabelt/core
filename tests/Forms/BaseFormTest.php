<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Form;
use Belt\Core\Forms\BaseForm;

class BaseFormTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Forms\BaseForm::__construct
     * @covers \Belt\Core\Forms\BaseForm::rules
     * @covers \Belt\Core\Forms\BaseForm::messages
     * @covers \Belt\Core\Forms\BaseForm::data
     */
    public function test()
    {
        app()['config']->set('belt.forms.test.template', BaseFormTestStubTemplate::class);

        $form = new Form();
        $form->config_key = 'test';

        # construct
        $template = $form->template();

        # rules
        $this->assertNotEmpty($template->rules('store'));

        # messages
        $this->assertNotEmpty($template->messages('store'));

        # data
        $data = $template->data(['name' => '', 'preference' => '']);
        $this->assertEquals('foo', array_get($data, 'name'));
        $this->assertEquals('default', array_get($data, 'preference'));
    }

}

class BaseFormTestStubTemplate extends BaseForm
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'foo',
        'preference' => [
            'default',
            'else',
        ],
    ];

    /**
     * @var array
     */
    protected $rules = [
        'store' => [
            'name' => 'required',
        ],
        'update' => [],
    ];

    /**
     * @var array
     */
    protected $messages = [
        'store' => [
            'name.required' => 'foo',
        ],
        'update' => [],
    ];
}