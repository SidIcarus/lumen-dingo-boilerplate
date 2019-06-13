<?php declare(strict_types=1);

namespace Tests;

use Laravel\Lumen\Testing\TestCase;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class BaseUrlTest extends TestCase
{

    public function base()
    {
        $this->get(
            '/',
            [
                'Accept' => 'application/x.lumen.dingo.boilerplate.v1+json',
            ]
        );
        $this->assertResponseOk();
        $this->seeJson(
            [
                'message' => 'Welcome to Lumen Dingo Boilerplate',
                'branch' => 'dev-master',
            ]
        );
    }


    public function baseNeedsHeader()
    {
        $this->get('/');
        $this->assertResponseStatus(400);
    }


    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }
}
