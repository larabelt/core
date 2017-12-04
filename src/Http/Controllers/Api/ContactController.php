<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt;
use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Services\ContactService;
use Illuminate\Http\Request;

/**
 * Class ContactController
 * @package Belt\Core\Http\Controllers\Api
 */
class ContactController extends ApiController
{
    /**
     * @var ContactService
     */
    private $service;

    /**
     * @param Request $request
     * @return ContactService
     */
    public function service(Request $request)
    {
        $service = $this->service ?: new ContactService();

        $service->setRequest($request);

        return $this->service = $service;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {

        $service = $this->service($request);

        if (!$service->validates()) {
            return response()->json($service->errors(), 422);
        }

        $service->queue();

        return response()->json([], 201);
    }

}
