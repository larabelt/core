<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Form;
use Belt\Core\Http\Requests\UpdateForm;
use Belt\Core\Tests\BeltTestCase;
use Mockery as m;

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
        app()['config']->set('belt.subtypes.forms.test.extension', UpdateFormTestExtension::class);

        $form = new Form(['subtype' => 'test']);

        $request = m::mock(UpdateForm::class . '[route]');
        $request->shouldReceive('route')->with('form')->andReturn($form);

        # rules
        $extension = new UpdateFormTestExtension($form);
        $this->assertEquals($extension->rules('update'), $request->rules());

        # messages
        $this->assertEquals($extension->messages('update'), $request->messages());
    }

}

class UpdateFormTestExtension extends \Belt\Core\Forms\BaseForm
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