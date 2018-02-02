<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt\Core\Alert;
use Belt\Core\Services\AlertService;
use Belt\Core\Http\Requests;
use Belt\Core\Http\Controllers\ApiController;
use Illuminate\Http\Request;

/**
 * Class AlertsController
 * @package Belt\Content\Http\Controllers\Api
 */
class AlertsController extends ApiController
{

    /**
     * @var Alert
     */
    public $alerts;

    /**
     * @var AlertService
     */
    public $service;

    /**
     * ApiController constructor.
     * @param Alert $alert
     */
    public function __construct(Alert $alert)
    {
        $this->alerts = $alert;
    }

    /**
     * @return AlertService
     */
    public function service()
    {
        return $this->service ?: new AlertService();
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
        $this->authorize('view', Alert::class);

        $request = Requests\PaginateAlerts::extend($request);

        $paginator = $this->paginator($this->alerts->query(), $request);

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\StoreAlert $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Requests\StoreAlert $request)
    {
        $this->authorize('create', Alert::class);

        $input = $request->all();

        $alert = $this->alerts->create(['name' => $input['name']]);

        $this->set($alert, $input, [
            'is_active',
            'slug',
            'body',
            'starts_at',
            'ends_at',
        ]);

        $alert->save();

        $this->service()->cache();

        return response()->json($alert, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Alert $alert
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Alert $alert)
    {
        $this->authorize('view', $alert);

        return response()->json($alert);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\UpdateAlert $request
     * @param Alert $alert
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Requests\UpdateAlert $request, Alert $alert)
    {
        $this->authorize('update', $alert);

        $input = $request->all();

        $this->set($alert, $input, [
            'is_active',
            'name',
            'slug',
            'body',
            'starts_at',
            'ends_at',
        ]);

        $alert->save();

        $this->service()->cache();

        return response()->json($alert);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Alert $alert
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Alert $alert)
    {
        $this->authorize('delete', $alert);

        $alert->delete();

        $this->service()->cache();

        return response()->json(null, 204);
    }
}
