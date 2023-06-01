<?php

namespace Tecnomanu\UniLogin\Tests;

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

class InvalidSessionTest extends BaseTestCase
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

    public function testInvalidSession()
    {
        $response = $this->get(config('unilogin.api_base_path').'unilogin/invalid-session');

        $response->assertResponseStatus(200);
    }
}
