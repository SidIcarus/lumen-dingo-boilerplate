<?php declare(strict_types=1);

namespace App\Http\Controllers\V1\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\User\UserRepository;
use App\Transformers\Auth\UserTransformer;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use Prettus\Repository\Criteria\RequestCriteria;


class UserController extends Controller
{

    protected $userRepository;


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


    public function index(Request $request): Response
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));

        return $this->paginatorOrCollection(
            $this->userRepository->paginate(),
            new UserTransformer()
        );
    }


    public function show(string $id): Response
    {
        $user = $this->userRepository->find($this->decodeHash($id));

        return $this->item($user, new UserTransformer());
    }


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
