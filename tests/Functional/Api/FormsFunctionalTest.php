<?php

use Belt\Core\Testing;
use Belt\Core\Form;

class FormsFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        app()['config']->set('belt.forms.test.template', FormsFunctionalTestTemplate::class);

        # store
        $response = $this->json('POST', '/api/v1/forms', [
            'config_key' => 'test',
            'name' => 'created',
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['config_key' => 'test']);
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

class FormsFunctionalTestTemplate extends \Belt\Core\Forms\BaseForm
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