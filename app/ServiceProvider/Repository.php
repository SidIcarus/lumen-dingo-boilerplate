<?php declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Auth\Permission\PermissionRepository;
use App\Repositories\Auth\Permission\PermissionRepositoryEloquent;
use App\Repositories\Auth\Role\RoleRepository;
use App\Repositories\Auth\Role\RoleRepositoryEloquent;
use App\Repositories\Auth\User\UserRepository;
use App\Repositories\Auth\User\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        $this->app->bind(
            PermissionRepository::class,
            PermissionRepositoryEloquent::class
        );
        $this->app->bind(
            RoleRepository::class,
            RoleRepositoryEloquent::class
        );
        $this->app->bind(
            UserRepository::class,
            UserRepositoryEloquent::class
        );
        //:end-bindings:
    }
}
