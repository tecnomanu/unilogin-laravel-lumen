<?php

namespace Tecnomanu\UniLogin\Providers;

use Illuminate\Support\ServiceProvider;
use Tecnomanu\UniLogin\Console\GenerateSecretCommand;
use Tecnomanu\UniLogin\Http\Middleware\SessionTokenMiddleware;
use Tecnomanu\UniLogin\Support\UniLogin;
use Tecnomanu\UniLogin\UniLoginManager;

abstract class AbstractServiceProvider extends ServiceProvider
{
    /**
     * The middleware aliases.
     *
     * @var array
     */
    protected $middlewareAliases = [
        'unilogin.session' => SessionTokenMiddleware::class,
    ];

    /**
     * Boot the service provider.
     *
     * @return void
     */
    abstract public function boot();

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAliases();
        $this->registerUniLoginCommand();
        $this->registerManager();

        $this->commands('unilogin:create.secret');
    }

    /**
     * Bind some aliases.
     *
     * @return void
     */
    protected function registerAliases()
    {
        $this->app->alias('unilogin', UniLogin::class);
        $this->app->alias('mailer', \Illuminate\Contracts\Mail\Mailer::class);
        $this->app->alias('mail.manager', Illuminate\Mail\MailManager::class);
        $this->app->alias('mail.manager', Illuminate\Contracts\Mail\Factory::class);
        $this->app->alias('Notification', Illuminate\Support\Facades\Notification::class);

    }


     /**
     * Register the Artisan command.
     *
     * @return void
     */
    protected function registerUniLoginCommand()
    {
        $this->app->singleton('unilogin:create.secret', function () {
            return new GenerateSecretCommand;
        });
    }


    /**
     * Register the bindings for the JWT Manager.
     *
     * @return void
     */
    protected function registerManager()
    {

        $this->app->singleton('unilogin', function ($app) {
            return new UniLoginManager($app);
        });
    }

}
