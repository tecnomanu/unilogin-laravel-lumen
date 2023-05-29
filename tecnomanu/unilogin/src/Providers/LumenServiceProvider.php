<?php

namespace Tecnomanu\UniLogin\Providers;


class LumenServiceProvider extends AbstractServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->configure('unilogin');

        $path = realpath(__DIR__.'/../../config/unilogin.php');
        $this->mergeConfigFrom($path, 'unilogin');

        $this->app->routeMiddleware($this->middlewareAliases);

        $this->loadRoutesFrom(__DIR__.'/../../routes.php');
    }
}
