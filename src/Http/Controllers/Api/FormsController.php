<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt;
use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Form;
use Belt\Core\Http\Requests;

class FormsController extends ApiController
{

    /**
     * @var Form
     */
    public $forms;

    /**
     * ApiController constructor.
     * @param Form $form
     */
    public function __construct(Form $form)
    {
        $this->forms = $form;
    }

    /**
     * @param Requests\StoreForm $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Requests\StoreForm $request)
    {
        $input = $request->all();

        $form = $this->forms->create(['config_key' => $input['config_key']]);

        $form->data = $form->template()->data($input);

        $form->save();

        // event
        $name = array_get($input, '_event', "forms.created.$form->config_key");
        $event = new Belt\Core\Events\ItemCreated($form, $name);
        event($name, $event);

        return response()->json($form, 201);
    }

    /**
     * @param $form
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($form)
    {
        $this->authorize('view', $form);

        return response()->json($form);
    }

    /**
     * @param Requests\UpdateForm $request
     * @param $form
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Requests\UpdateForm $request, $form)
    {
        $this->authorize('update', $form);

        $input = $request->all();

        $form->data = $form->template()->data($input);

        $form->save();

        // event
        $name = array_get($input, '_event', "forms.updated.$form->config_key");
        $event = new Belt\Core\Events\ItemUpdated($form, $name);
        event($name, $event);

        return response()->json($form);
    }

}
