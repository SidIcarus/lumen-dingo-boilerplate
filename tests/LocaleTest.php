<?php declare(strict_types=1);

namespace Tests;

use App\Models\Auth\User\User;
use Laravel\Lumen\Testing\TestCase;
use Laravel\Passport\Passport;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class LocaleTest extends TestCase
{

    public function getAll()
    {
        Passport::actingAs(factory(User::class)->create());
        $this->get(
            'localizations',
            [
                'Accept' => 'application/x.lumen.dingo.boilerplate.v1+json',
                'Authorization' => 'Bearer xxxxx',
            ]
        )
            ->assertResponseOk();
    }


    public function checkAllLocale(string $locale = null)
    {
        $headers = [
            'Accept' => 'application/x.lumen.dingo.boilerplate.v1+json',
        ];

        if (!is_null($locale)) {
            $headers['Accept-Language'] = $locale;
        }

        $this->get('/', $headers);

        if ($locale == 'xxx') {
            $this->assertResponseStatus(412);
            $this->seeJson(
                [
                    'message' => 'Unsupported Language.',
                    'status_code' => 412,
                ]
            );

            return;
        }

        $message = 'Welcome to Lumen Dingo Boilerplate';
        switch ($locale) {
            case'xxx,fr';
                $locale = 'fr';
                $message = 'Bienvenue chez Lumen Dingo Boilerplate';
                break;
            default:
                $locale = $locale ?: config('app.locale');
                break;
        }
        $this->assertResponseOk();
        $this->assertEquals(app('translator')->getLocale(), $locale);
        $this->seeJson(
            [
                'message' => $message,
                'branch' => 'dev-master',
            ]
        );
    }


    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }
}
