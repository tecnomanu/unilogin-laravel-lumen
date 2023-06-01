<?php

namespace Tecnomanu\UniLogin\Tests;

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

class CallbackTest extends BaseTestCase
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

    public function testHandleCallback()
    {
        $response = $this->get(config('unilogin.api_base_path').'unilogin/callback?token=your_token_here'); // Reemplaza 'your_token_here' con un token de prueba válido

        $response->assertResponseStatus(200);
    }
}
