<?php

namespace Tecnomanu\UniLogin\Tests;

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

class PollingTest extends BaseTestCase
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

    public function testPolling()
    {
        $token = 'your_token_here'; // Debes generar o obtener un token válido para esta prueba

        $response = $this->get(config('unilogin.api_base_path').'unilogin/polling', [], ['Authorization' => 'Bearer ' . $token]);

        $response->assertResponseStatus(200);
    }
}
