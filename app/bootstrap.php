<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Console\Kernel;
use App\Exception\Handler as ExceptionHandler;
use App\Http\Middleware\Localization as LocalizationMiddleware;
use App\Provider\App as AppServiceProvider;
use App\Provider\Guard as GuardServiceProvider;
use App\Provider\Repository as RepositoryServiceProvider;
use Barryvdh\Cors\HandleCors;
use Barryvdh\Cors\ServiceProvider as CorsServiceProvider;
use Dingo\Api\Auth\Auth;
use Dingo\Api\Exception\Handler as DingoExceptionHandler;
use Dingo\Api\Exception\ValidationHttpException;
use Dingo\Api\Provider\LumenServiceProvider as DingoServiceProvider;
use Dingo\Api\Routing\Router;
use Dusterio\LumenPassport\PassportServiceProvider as LumenPassport;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Console\Kernel as KernelContract;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Application;
use Laravel\Passport\PassportServiceProvider;
use Liyu\Dingo\SerializerSwitch;
use Prettus\Repository\Providers\LumenRepositoryServiceProvider;
use Prettus\Validator\Exceptions\ValidatorException;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\PermissionServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vinkla\Hashids\HashidsServiceProvider;

(new LoadEnvironmentVariables(dirname(__DIR__)))->bootstrap();

$app = new Application(dirname(__DIR__));

$app->withFacades();
$app->withEloquent();

$app->configure('api');
$app->configure('auth');
$app->configure('cors');
$app->configure('hashids');
$app->configure('localization');
$app->configure('permission');
$app->configure('repository');
$app->configure('setting');

$app->alias('cache', CacheManager::class);

$app->singleton(ExceptionHandlerContract::class, ExceptionHandler::class);
$app->singleton(KernelContract::class, Kernel::class);

$app->middleware([LocalizationMiddleware::class, HandleCors::class]);
$app->routeMiddleware(
    [
        'permission' => PermissionMiddleware::class,
        'role' => RoleMiddleware::class,
        'serializer' => SerializerSwitch::class,
    ]
);

$app->register(AppServiceProvider::class);
$app->register(RepositoryServiceProvider::class);
$app->register(PassportServiceProvider::class);
$app->register(LumenPassport::class);
$app->register(LumenRepositoryServiceProvider::class);
$app->register(PermissionServiceProvider::class);
$app->register(HashidsServiceProvider::class);
$app->register(CorsServiceProvider::class);
$app->register(DingoServiceProvider::class);

$app[Auth::class]->extend(
    'passport',
    function ($app) {
        return $app[GuardServiceProvider::class];
    }
);

$app[DingoExceptionHandler::class]
    ->register(
        function (RoleAlreadyExists $exception) {
            abort(422, $exception->getMessage());
        }
    );
$app[DingoExceptionHandler::class]
    ->register(
        function (ValidatorException $exception) {
            throw new ValidationHttpException(
                $exception->getMessageBag(), $exception
            );
        }
    );

$app[DingoExceptionHandler::class]
    ->register(
        function (ModelNotFoundException $exception) {
            throw new NotFoundHttpException(
                $exception->getMessage(), $exception
            );
        }
    );

if (class_exists('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider')) {
    $app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');
}

$api = $app[Router::class];

// Version 1
$api->version(
    'v1',
    [
        'namespace' => 'App\Http\Controllers\V1',
    ],
    function ($api) {
        require __DIR__ . '/../routes/v1/api.php';
    }
);



$app->router->group(
    [
        'namespace' => 'App\Http\Controllers',
    ],
    function ($router) use ($app) {
        require __DIR__ . '/../routes/web.php';
    }
);

return $app;
