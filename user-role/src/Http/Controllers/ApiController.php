<?php

namespace Ohio\Core\UserRole\Http\Controllers;

use Illuminate\Http\Request;
use Ohio\Core\User;
use Ohio\Core\UserRole;
use Ohio\Core\UserRole\Criteria\UserRolePaginateCriteria;
use Ohio\Core\Base\Http\Controllers\BaseApiController;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;

class ApiController extends BaseApiController
{

    /**
     * @var User\UserRoleRepository
     */
    protected $repository;

    /**
     * @var User\UserRoleValidator
     */
    protected $validator;


    public function __construct(User\UserRoleRepository $repository, User\UserRoleValidator $validator)
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

        //$this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        $this->repository->pushCriteria(new UserRolePaginateCriteria($request->all()));

        $this->data = $this->repository->paginate();

        return response()->json($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRoleCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    //public function store(UserRoleCreateRequest $request)
    public function store(Request $request)
    {

        try {

            $this->repository->skipPresenter();

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $userRole = $this->repository->create($request->all());

            $response = [
                'message' => 'UserRole created.',
                'data'    => $this->data,
            ];

            $headers['UserRole'] = url("api/v1/user-roles/$userRole->id");

            return response()->json($userRole, 201, $headers);

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
     * @param  UserRoleUpdateRequest $request
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
                'message' => 'UserRole updated.',
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
