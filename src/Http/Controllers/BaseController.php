<?php
namespace Ohio\Base\Http\Controllers;

use Input, Redirect, Request, Response, Session;
//use Illuminate\Database\Eloquent;
use Illuminate\Routing\Controller;
//use Illuminate\Support;
//use Symfony\Component\HttpFoundation;


class BaseController extends Controller
{

    protected $mode = 'api';

    public $status = 200;

    public $input = [];

    public $errors = [];

    public $flash = [];

    public $nested = [];

    public $paginator;

    public $content;

    /**
     * @var Entity\BaseRepository
     */
    //public $repository;
    protected $repository_class;

    /**
     * @var Entity\BaseValidator
     */
    public $validator;
    protected $validator_class;

    public function __construct()
    {

        //$this->setInput();

//        $this->flash = new Support\MessageBag();
//
//        if ($this->repository_class) {
//            $this->repository = new $this->repository_class;
//        }
//
//        if ($this->validator_class) {
//            $this->validator = new $this->validator_class;
//        }

    }

    public function setInput()
    {
        $this->input = Input::all();
    }

    public function response($status = 200, $headers = array())
    {
        $this->status = $status;

        // content for response
        $content_array = json_decode(json_encode($this->content), true);
        $this->content = json_decode(json_encode($this->content), false);

        // redirect
        $redirect = array_get($this->input, '_redirect');
        $complete = array_get($this->input, '_complete');
        if ($status == 201 && $complete) {
            $redirect = $complete;
        }
        $redirect = str_replace('{id}', array_get($content_array, 'data.id'), $redirect);

        if (!Request::ajax()) {
            if ($redirect) {
                if (!$this->flash->isEmpty()) {
                    foreach ($this->flash->getMessages() as $key => $msgs) {
                        Session::flash($key, $msgs);
                    }
                }

                return $this->redirect($redirect, 302, $headers);
            }
        }

        if ($this->mode == 'api') {
            $headers = array_replace($headers, ['Content-Type' => 'application/json']);
            return Response::make(json_encode($this->content, JSON_PRETTY_PRINT), $status, $headers);
        }

        return Response::make('', $status, $headers);
    }

    public function error($status = 400, $errors = [])
    {

        if ($this->mode == 'html') {
            $this->pushStandardError($status);
        }

        $this->errors = array_merge($this->errors, $errors);

        $this->content = $this->errors;

        return $this->response($status);
    }

    public function pushStandardError($status)
    {
        $defaults = HttpFoundation\Response::$statusTexts;
        $defaults['422'] = 'Your data did not pass validation.';

        if (array_get($defaults, $status)) {
            $errors[] = sprintf('Bummer! %s [CODE #%s]', array_get($defaults, $status), $status);
        }

        $this->errors = array_merge($this->errors, $errors);
    }

    public function redirect($path, $status = 302, $headers = [])
    {

        $response = Redirect::to($path, $status, $headers);

        if ($this->errors) {
            $response->withErrors($this->errors);
        }

        if ($this->status == 422) {
            $response->withInput($this->input);
        }

        return $response;
    }

}
