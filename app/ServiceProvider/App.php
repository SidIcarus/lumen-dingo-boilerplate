<?php declare(strict_types=1);

namespace App\ServiceProvider;

use DB;
use Dusterio\LumenPassport\LumenPassport;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use PDO;
use Schema;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        if (!(DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME) === 'mysql'
            && version_compare(
                DB::connection()->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION),
                '5.7.8',
                'ge'
            ))) {
            Schema::defaultStringLength(191);
        }

        LumenPassport::routes(
            $this->app->router,
            [
                // 'prefix' => 'v1/oauth',
            ]
        );

        LumenPassport::tokensExpireIn(
            Carbon::now()->addMinutes(
                config('setting.api.token.access_token_expire')
            )
        );

        Passport::refreshTokensExpireIn(
            Carbon::now()->addMinutes(
                config('setting.api.token.refresh_token_expire')
            )
        );
    }
}
