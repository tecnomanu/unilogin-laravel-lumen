<?php

namespace Tecnomanu\UniLogin\Providers;

use Illuminate\Support\ServiceProvider;
use Tecnomanu\UniLogin\UniLoginManager;

class LaravelServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->configure('unilogin');

        $path = realpath(__DIR__.'/../../config/config.php');
        $this->mergeConfigFrom($path, 'unilogin');

        $this->app->routeMiddleware($this->middlewareAliases);

        $this->loadRoutesFrom(__DIR__.'/../../routes.php');

        // Este es el lugar para bootstrapping. Puedes publicar configuraciones, vistas, migraciones desde aquí.
        // También puedes registrar rutas o cargar traducciones.

        if ($this->app->runningInConsole()) {

            // Publicar la configuración de UniLogin para que los usuarios puedan personalizarla.
            $this->publishes([
                __DIR__.'/../../config/unilogin.php' => function_exists('config_path')
                                                        ? config_path('unilogin.php')
                                                        : base_path('config/unilogin.php'),
            ], 'unilogin-config');

            // Publicar las migraciones de la base de datos.
            $this->publishes([
                __DIR__.'/../../database/migrations/' => database_path('migrations'),
            ], 'unilogin-migrations');
            
            $this->publishes([
                __DIR__.'/../../Notifications' => function_exists('app_path')
                                                ? app_path('Notifications')
                                                : base_path('app/Notifications'),
            ]);
        }
    }
}
