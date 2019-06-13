<?php declare(strict_types=1);

namespace App\Providers;

use Dingo\Api\Auth\Provider\Authorization;
use Dingo\Api\Routing\Route;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class GuardServiceProvider extends Authorization
{
    public function authenticate(Request $request, Route $route)
    {
        $this->validateAuthorizationHeader($request);

        if (!$user = app('auth')->user()) {
            throw new UnauthorizedHttpException(
                get_class($this),
                'Unable to authenticate with invalid API key and token.'
            );
        }

        return $user;
    }

    public function getAuthorizationMethod(): string
    {
        return 'bearer';
    }
}
