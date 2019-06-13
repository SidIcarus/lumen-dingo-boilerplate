<?php declare(strict_types=1);

namespace App\Http\Controllers\V1\Frontend\User;

use App\Http\Controllers\Controller;
use App\Transformers\Auth\UserTransformer;
use Dingo\Api\Http\Response;

/**
 * Class UserAccessController
 *
 * @package App\Http\Controllers\V1\Backend\Auth\User
 */
class UserAccessController extends Controller
{
    /**
     * @return Response
     * @api                {get} /profile Get current authenticated user
     * @apiName            get-authenticated-user
     * @apiGroup           UserAccess
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             UserResponse
     *
     */
    public function profile(): Response
    {
        return $this->item($this->user(), new UserTransformer());
    }
}
