<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Form;
use Belt\Core\Http\Requests\StoreForm;
use Belt\Core\Services\FormService;
use Tests\Belt\Core\BeltTestCase;

class StoreFormTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\StoreForm::service
     * @covers \Belt\Core\Http\Requests\StoreForm::extension
     * @covers \Belt\Core\Http\Requests\StoreForm::rules
     * @covers \Belt\Core\Http\Requests\StoreForm::messages
     */
    public function test()
    {
        app()['config']->set('belt.subtypes.forms.test.extension', StoreFormTestExtension::class);

        $form = new Form(['subtype' => 'test']);

        $request = new StoreForm(['subtype' => 'test']);

        # service
        $this->assertInstanceOf(FormService::class, $request->service());

        # extension
        $this->assertInstanceOf(StoreFormTestExtension::class, $request->extension());

        # rules
        $extension = new StoreFormTestExtension($form);
        $this->assertEquals($extension->rules('store'), $request->rules());
        $this->assertNotEmpty(array_get((new StoreForm())->rules(), 'subtype'));

        # messages
        $this->assertEquals($extension->messages('store'), $request->messages());
        $this->assertEquals([], (new StoreForm())->messages());
    }

}

class StoreFormTestExtension extends \Belt\Core\Forms\BaseForm
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