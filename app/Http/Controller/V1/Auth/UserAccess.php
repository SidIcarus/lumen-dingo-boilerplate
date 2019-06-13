<?php declare(strict_types=1);

namespace App\Http\Controllers\V1\Frontend\User;

use App\Http\Controllers\Controller;
use App\Transformers\Auth\UserTransformer;
use Dingo\Api\Http\Response;


class UserAccessController extends Controller
{

    public function profile(): Response
    {
        return $this->item($this->user(), new UserTransformer());
    }
}
