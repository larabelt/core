<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt;
use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\TranslatableString;
use Belt\Core\Http\Requests;
use Illuminate\Http\Request;

class TranslatableStringsController extends ApiController
{

    /**
     * The repository instance.
     *
     * @var TranslatableString
     */
    public $translatableStrings;

    /**
     * ApiController constructor.
     * @param TranslatableString $translatableString
     */
    public function __construct(TranslatableString $translatableString)
    {
        $this->translatableStrings = $translatableString;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize(['view', 'create', 'update', 'delete'], TranslatableString::class);

        $request = Requests\PaginateTranslatableStrings::extend($request);

        $paginator = $this->paginator($this->translatableStrings->query(), $request);

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\StoreTranslatableString $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Requests\StoreTranslatableString $request)
    {
        $this->authorize('create', TranslatableString::class);

        $input = $request->all();

        $translatableString = $this->translatableStrings->create(['value' => $input['value']]);

        $this->set($translatableString, $input, [
            'value',
        ]);

        $translatableString->save();

        return response()->json($translatableString, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param TranslatableString $translatableString
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(TranslatableString $translatableString)
    {
        $this->authorize(['view', 'create', 'update', 'delete'], $translatableString);

        return response()->json($translatableString);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Requests\UpdateTranslatableString $request
     * @param TranslatableString $translatableString
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Requests\UpdateTranslatableString $request, TranslatableString $translatableString)
    {

        $this->authorize('update', $translatableString);

        $input = $request->all();

        $this->set($translatableString, $input, [
            'value',
        ]);

        $translatableString->save();

        return response()->json($translatableString);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param TranslatableString $translatableString
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(TranslatableString $translatableString)
    {
        $this->authorize('delete', $translatableString);

        $translatableString->delete();

        return response()->json(null, 204);
    }
}
