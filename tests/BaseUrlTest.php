<?php

namespace Tests;

use Laravel\Lumen\Testing\TestCase;

class BaseUrlTest extends TestCase
{
    /**
     * @test
     */
    public function base()
    {
        $this->get('/', [
            'Accept' => 'application/x.lumen.dingo.boilerplate.v1+json',
        ]);
        $this->assertResponseOk();
        $this->seeJson([
            'message' => 'Welcome to Lumen Dingo Boilerplate',
            'branch' => 'dev-master',
        ]);
    }

    /**
     * @test
     */
    public function baseNeedsHeader()
    {
        $this->get('/');
        $this->assertResponseStatus(400);
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
