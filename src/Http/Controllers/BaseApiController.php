<?php

namespace Ohio\Core\Http\Controllers;

use Illuminate\Http\Request;

//use App\Http\Requests;
//use App\Http\Requests\PostCreateRequest;
//use App\Http\Requests\PostUpdateRequest;

use Ohio\Core\Domain\BaseRepository;
use Ohio\Core\Domain\BaseValidator;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class BaseApiController extends Controller
{

    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * @var BaseRepository
     */
    protected $repository;

    /**
     * @var BaseValidator
     */
    protected $validator;

    /**
     * @var mixed
     */
    protected $data;

}