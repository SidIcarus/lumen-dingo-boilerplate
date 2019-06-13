<?php declare(strict_types=1);
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\Auth\Permission\PermissionRepository::class,
            \App\Repositories\Auth\Permission\PermissionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Auth\Role\RoleRepository::class,
            \App\Repositories\Auth\Role\RoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Auth\User\UserRepository::class,
            \App\Repositories\Auth\User\UserRepositoryEloquent::class);
        //:end-bindings:
    }

}
