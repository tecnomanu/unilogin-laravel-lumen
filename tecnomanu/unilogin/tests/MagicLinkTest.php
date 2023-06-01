<?php

namespace Tecnomanu\UniLogin\Tests;

use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Tecnomanu\UniLogin\Notifications\MagicLinkNotification;
use Tecnomanu\UniLogin\Repositories\UserRepository;

class MagicLinkTest extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../../../../bootstrap/app.php';
    }

    public function testSendMagicLink()
    {
        // Falso el Mail Facade
        Notification::fake();
        Queue::fake();

        $userModel = new UserRepository();

        // Crea una instancia de usuario
        $user = $userModel->findByEmail('test@test.com');

        // Envía la solicitud para crear el enlace mágico
        $response = $this->json('POST', config('unilogin.api_base_path').'unilogin', ['email' => $user->email]);

         // Asegúrate de que la notificación se envía
        Notification::assertSentTo(
            [$user], MagicLinkNotification::class
        );

        // Asegúrate de que la respuesta tiene éxito
        $response->assertResponseStatus(200);
        $response->seeJsonStructure(['status', 'data' => ['session_token', 'message']]);
    }
}