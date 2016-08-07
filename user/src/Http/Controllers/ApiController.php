<?php

namespace Ohio\Core\User\Http\Controllers;

use Illuminate\Http\Request;
use Ohio\Core\User;
use Ohio\Core\User\Criteria\UserPaginateCriteria;
use Ohio\Core\Base\Http\Controllers\BaseApiController;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;

class ApiController extends BaseApiController
{

    /**
     * @var User\UserRepository
     */
    protected $repository;

    /**
     * @var User\UserValidator
     */
    protected $validator;


    public function __construct(User\UserRepository $repository, User\UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->repository->skipPresenter(false);

        $this->repository->pushCriteria(new UserPaginateCriteria($request->all()));

        $this->data = $this->repository->paginate();

        return response()->json($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    //public function store(UserCreateRequest $request)
    public function store(Request $request)
    {

        try {

            //$this->repository->skipPresenter();

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $user = $this->repository->create($request->all());

            $response = [
                'message' => 'User created.',
                'data'    => $this->data,
            ];

            $headers['User'] = url("api/v1/users/{$user['data']['id']}");

            return response()->json($user['data'], 201, $headers);

        } catch (ValidatorException $e) {
            abort(422, $e->getMessageBag()->toJson());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {
            $this->data = $this->repository->find($id);
        } catch (\Exception $e) {
            abort(404, 'Record not found.');
        }

        return response()->json($this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $this->show($id);

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $this->data = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'User updated.',
                'data'    => $this->data,
            ];

            return response()->json($this->data);

//            if ($request->wantsJson()) {
//                return response()->json($response);
//            }
//
//            return redirect()->back()->with('message', $response['message']);

        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        return response()->json(null, 204);
    }
}