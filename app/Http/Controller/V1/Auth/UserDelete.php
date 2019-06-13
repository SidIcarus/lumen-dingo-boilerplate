<?php declare(strict_types=1);


namespace App\Http\Controllers\V1\Backend\Auth\User;

use App\Criterion\Eloquent\OnlyTrashedCriteria;
use App\Http\Controllers\Controller;
use App\Repositories\Auth\User\UserRepository;
use App\Transformers\Auth\UserTransformer;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;


class UserDeleteController extends Controller
{

    protected $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $permissions = $userRepository->makeModel()::PERMISSIONS;

        $this->middleware(
            'permission:' . $permissions['deleted list'],
            ['only' => 'deleted']
        );
        $this->middleware('permission:' . $permissions['restore'], ['only' => 'restore']);
        $this->middleware('permission:' . $permissions['purge'], ['only' => 'purge']);

        $this->userRepository = $userRepository;
    }


    public function restore(string $id): Response
    {
        $user = $this->userRepository->restore($this->decodeHash($id));

        return $this->item($user, new UserTransformer());
    }


    public function deleted(Request $request): Response
    {
        $this->userRepository->pushCriteria(new OnlyTrashedCriteria());
        $this->userRepository->pushCriteria(new RequestCriteria($request));

        return $this->paginatorOrCollection(
            $this->userRepository->paginate(),
            new UserTransformer()
        );
    }


    public function purge(string $id): Response
    {
        $this->userRepository->forceDelete($this->decodeHash($id));

        return $this->response->noContent();
    }
}
