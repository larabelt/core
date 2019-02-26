<?php namespace Tests\Belt\Core\Feature\Api;

use Tests\Belt\Core;
use Belt\Core\Form;

class FormsFunctionalUnitTest extends \Tests\Belt\Core\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        app()['config']->set('belt.subtypes.forms.test.extension', FormsFunctionalTestExtension::class);

        # store
        $response = $this->json('POST', '/api/v1/forms', [
            'subtype' => 'test',
            'name' => 'created',
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['subtype' => 'test']);
        $formID = array_get($response->json(), 'id');

        # show
        $response = $this->json('GET', "/api/v1/forms/$formID");
        $response->assertStatus(200);

        # update
        $response = $this->json('PUT', "/api/v1/forms/$formID", [
            'name' => 'updated',
        ]);
        $this->assertEquals('updated', array_get($response->json(), 'data.name'));

    }

}

class FormsFunctionalTestExtension extends \Belt\Core\Forms\BaseForm
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => '',
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