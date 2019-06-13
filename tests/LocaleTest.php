<?php

namespace Tests;

use App\Models\Auth\User\User;
use Laravel\Lumen\Testing\TestCase;
use Laravel\Passport\Passport;

class LocaleTest extends TestCase
{
    /**
     * @test
     */
    public function getAll()
    {
        Passport::actingAs(factory(User::class)->create());
        $this->get('localizations', [
            'Accept' => 'application/x.lumen.dingo.boilerplate.v1+json',
            'Authorization' => 'Bearer xxxxx',
        ])
            ->assertResponseOk();
    }

    /**
     * @param string|null $locale
     *
     * @test
     * @testWith ["en"]
     *           [null]
     *           ["xxx"]
     *           ["xxx,fr"]
     */
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
            $this->seeJson([
                'message' => 'Unsupported Language.',
                'status_code' => 412,
            ]);
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
        $this->seeJson([
            'message' => $message,
            'branch' => 'dev-master',
        ]);
    }

    /**
     * Creates the application.
     *
     * Needs to be implemented by subclasses.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }
}
