<?php namespace Tests\Belt\Core\Unit\Forms;

use Belt\Core\Form;
use Belt\Core\Forms\BaseForm;
use Tests\Belt\Core\BeltTestCase;

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
        app()['config']->set('belt.subtypes.forms.test.extension', BaseFormTestStubExtension::class);

        $form = new Form(['subtype' => 'test']);

        # construct
        $extension = $form->extension();

        # rules
        $this->assertNotEmpty($extension->rules('store'));

        # messages
        $this->assertNotEmpty($extension->messages('store'));

        # data
        $data = $extension->data(['name' => '', 'preference' => '']);
        $this->assertEquals('foo', array_get($data, 'name'));
        $this->assertEquals('default', array_get($data, 'preference'));
    }

}

class BaseFormTestStubExtension extends BaseForm
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