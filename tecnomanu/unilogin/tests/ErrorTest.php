<?php

namespace Tecnomanu\UniLogin\Tests;

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

class ErrorTest extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function testErrorLogin()
    {
        $response = $this->get(config('unilogin.api_base_path').'unilogin/error');

        $response->assertResponseStatus(200);
    }
}
