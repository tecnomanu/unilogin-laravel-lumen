# UniLogin 
## Autenticación Universal a través de Enlace Mágico

UniLogin es un paquete Laravel/Lumen para proporcionar autenticación universal mediante enlaces mágicos. Este método de autenticación permite a los usuarios iniciar sesión sin necesidad de contraseñas, en su lugar, solo necesitan hacer clic en el enlace que reciben en su correo electrónico.

## Instalación

Para comenzar a usar UniLogin en tus proyectos Laravel o Lumen, primero necesitarás instalar el paquete a través de composer.

bashCopy code

`composer require tecnomanu/unilogin-laravel-lumen`

### Laravel

Una vez que hayas instalado el paquete, debes agregar el ServiceProvider a la matriz de proveedores en tu archivo `config/app.php`.


`'providers' => [     // ...     Tecnomanu\UniLogin\Providers\LaravelServiceProvider::class, ],`

### Lumen

Para usar UniLogin en Lumen, debes agregar el ServiceProvider a tu archivo `bootstrap/app.php`.


`$app->register(Tecnomanu\UniLogin\Providers\LumenServiceProvider::class);`

## Configuración

Una vez que hayas instalado y registrado el proveedor de servicios, puedes publicar el archivo de configuración del paquete.

En Laravel, utiliza el siguiente comando Artisan:

bashCopy code

`php artisan vendor:publish --provider="Tecnomanu\UniLogin\Providers\LaravelServiceProvider"`

En Lumen, tendrás que copiar manualmente el archivo de configuración a tu carpeta de configuración.

Finalmente, debes establecer las siguientes variables de entorno en tu archivo `.env`:

`UNILOGIN_SECRET= UNILOGIN_TOKEN_LIFETIME=15 UNILOGIN_CALLBACK_URL=/unilogin/callback UNILOGIN_API_BASE_PATH=`

## Uso

UniLogin proporciona una sencilla API para generar enlaces mágicos. Puedes generar un enlace mágico para un usuario así:


`$magicLink = app('unilogin')->createMagicLink($email);`

El usuario recibirá un correo electrónico con el enlace mágico. Cuando el usuario haga clic en el enlace, será autenticado en el sistema.

## Configuración adicional para Lumen

Si estás utilizando Lumen, necesitarás agregar algunas configuraciones adicionales para que este paquete funcione correctamente.

Añade las siguientes líneas en tu archivo `bootstrap/app.php`:

```php
$app->alias('view', Illuminate\View\Factory::class);

$app->alias('mailer', \Illuminate\Contracts\Mail\Mailer::class);
$app->alias('mail.manager', Illuminate\Mail\MailManager::class);
$app->alias('mail.manager', Illuminate\Contracts\Mail\Factory::class);
$app->alias('Notification', Illuminate\Support\Facades\Notification::class);

$app->configure('mail');
$app->configure('view');
```

## Contribuciones

Las contribuciones son bienvenidas. Por favor, envía tus pull requests.

## Soporte

Si tienes algún problema o sugerencia, por favor, abre un issue.