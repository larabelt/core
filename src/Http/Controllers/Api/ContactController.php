<?php

namespace Belt\Core\Http\Controllers\Api;

use Mail;
use Belt\Core\Http\Requests;
use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Mail\ContactSubmitted;

/**
 * Class ContactController
 * @package Belt\Core\Http\Controllers\Api
 */
class ContactController extends ApiController
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\PostContact $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Requests\PostContact $request)
    {
        /**
         * @todo queue contact request
         */

        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new ContactSubmitted($request->all()));

        return response()->json([], 201);
    }

}
