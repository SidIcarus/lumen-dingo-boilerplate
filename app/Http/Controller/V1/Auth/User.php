<?php declare(strict_types=1);

namespace App\Http\Controllers\V1\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\User\UserRepository;
use App\Transformers\Auth\UserTransformer;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\V1\Backend\Auth\User
 */
class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserController constructor.
     *
     * @param \App\Repositories\Auth\User\UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $permissions = $userRepository->makeModel()::PERMISSIONS;

        $this->middleware('permission:' . $permissions['index'], ['only' => 'index']);
        $this->middleware('permission:' . $permissions['create'], ['only' => 'store']);
        $this->middleware('permission:' . $permissions['show'], ['only' => 'show']);
        $this->middleware('permission:' . $permissions['update'], ['only' => 'update']);
        $this->middleware('permission:' . $permissions['destroy'], ['only' => 'destroy']);

        $this->userRepository = $userRepository;
    }

    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @return Response
     * @api                {get} /auth/users Get all users
     * @apiName            get-all-users
     * @apiGroup           User
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UsersResponse
     *
     */
    public function index(Request $request): Response
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));

        return $this->paginatorOrCollection(
            $this->userRepository->paginate(),
            new UserTransformer()
        );
    }

    /**
     * @param string $id
     *
     * @return Response
     * @api                {get} /auth/users/{id} Show user
     * @apiName            show-user
     * @apiGroup           User
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UserResponse
     *
     */
    public function show(string $id): Response
    {
        $user = $this->userRepository->find($this->decodeHash($id));

        return $this->item($user, new UserTransformer());
    }

    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @return Response
     * @api                {post} /auth/users Store user
     * @apiName            store-user
     * @apiGroup           User
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UserCreatedResponse
     * @apiParam {String} first_name (required)
     * @apiParam {String} last_name (required)
     * @apiParam {String} email (required)
     * @apiParam {String} password (required)
     *
     */
    public function store(Request $request): Response
    {
        return $this->item(
            $this->userRepository->create(
                $request->only(
                    [
                        'first_name',
                        'last_name',
                        'email',
                        'password',
                    ]
                )
            ),
            new UserTransformer()
        )
            ->statusCode(201);
    }

    /**
     * @param \Dingo\Api\Http\Request $request
     * @param string $id
     *
     * @return Response
     * @api                {put} /auth/users/ Update user
     * @apiName            update-user
     * @apiGroup           User
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UserResponse
     * @apiParam {String} first_name
     * @apiParam {String} last_name
     * @apiParam {String} email
     * @apiParam {String} password
     *
     */
    public function update(Request $request, string $id): Response
    {
        $user = $this->userRepository->update(
            $request->only(
                [
                    'first_name',
                    'last_name',
                    'email',
                    'password',
                ]
            ),
            $this->decodeHash($id)
        );

        return $this->item($user, new UserTransformer());
    }

    /**
     * @param string $id
     *
     * @return Response
     * @api                {delete} /auth/users/{id} Destroy user
     * @apiName            destroy-user
     * @apiGroup           User
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             NoContentResponse
     *
     */
    public function destroy(string $id): Response
    {
        $id = $this->decodeHash($id);
        if (app('auth')->id() == $id) {
            $this->response->errorForbidden('You cannot delete your self.');
        }

        $this->userRepository->delete($id);

        return $this->response->noContent();
    }
}
