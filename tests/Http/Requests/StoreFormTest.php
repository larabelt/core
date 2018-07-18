<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Http\Requests\StoreForm;
use Belt\Core\Form;
use Belt\Core\Services\FormService;

class StoreFormTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\StoreForm::service
     * @covers \Belt\Core\Http\Requests\StoreForm::template
     * @covers \Belt\Core\Http\Requests\StoreForm::rules
     * @covers \Belt\Core\Http\Requests\StoreForm::messages
     */
    public function test()
    {
        app()['config']->set('belt.forms.test.template', StoreFormTestTemplate::class);

        $form = new Form(['config_key' => 'test']);

        $request = new StoreForm(['config_key' => 'test']);

        # service
        $this->assertInstanceOf(FormService::class, $request->service());

        # template
        $this->assertInstanceOf(StoreFormTestTemplate::class, $request->template());

        # rules
        $template = new StoreFormTestTemplate($form);
        $this->assertEquals($template->rules('store'), $request->rules());
        $this->assertNotEmpty(array_get((new StoreForm())->rules(), 'config_key'));

        # messages
        $this->assertEquals($template->messages('store'), $request->messages());
        $this->assertEquals([], (new StoreForm())->messages());
    }

}

class StoreFormTestTemplate extends \Belt\Core\Forms\BaseForm
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