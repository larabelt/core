<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Http\Requests\UpdateForm;
use Belt\Core\Form;

class UpdateFormTest extends BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Requests\UpdateForm::rules
     * @covers \Belt\Core\Http\Requests\UpdateForm::messages
     */
    public function test()
    {
        app()['config']->set('belt.forms.test.template', UpdateFormTestTemplate::class);

        $form = new Form(['config_key' => 'test']);

        $request = m::mock(UpdateForm::class . '[route]');
        $request->shouldReceive('route')->with('form')->andReturn($form);

        # rules
        $template = new UpdateFormTestTemplate($form);
        $this->assertEquals($template->rules('update'), $request->rules());

        # messages
        $this->assertEquals($template->messages('update'), $request->messages());
    }

}

class UpdateFormTestTemplate extends \Belt\Core\Forms\BaseForm
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
        'update' => [
            'name' => 'required',
        ],
    ];

    /**
     * @var array
     */
    protected $messages = [
        'update' => [
            'name.required' => 'foo',
        ],
    ];
}