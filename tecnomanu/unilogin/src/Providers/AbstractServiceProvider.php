<?php

namespace Tecnomanu\UniLogin\Providers;

use Illuminate\Support\ServiceProvider;

// Middleware's
use Tecnomanu\UniLogin\Http\Middleware\AcceptSessionMiddleware;
use Tecnomanu\UniLogin\Http\Middleware\CallbackTokenMiddleware;
use Tecnomanu\UniLogin\Http\Middleware\SuccessTokenMiddleware;
use Tecnomanu\UniLogin\Http\Middleware\PollingTokenMiddleware;

// Contracts
use Tecnomanu\UniLogin\Contracts\Repositories\MagicLinkRepositoryContract;
use Tecnomanu\UniLogin\Contracts\Repositories\SessionRepositoryContract;
use Tecnomanu\UniLogin\Contracts\Repositories\UserRepositoryContract;
use Tecnomanu\UniLogin\Contracts\Services\MagicLinkServiceContract;
use Tecnomanu\UniLogin\Contracts\Services\SessionServiceContract;
use Tecnomanu\UniLogin\Contracts\Services\TokenServiceContract;
use Tecnomanu\UniLogin\Contracts\Services\UniLoginServiceContract;

// Commands
use Tecnomanu\UniLogin\Console\GenerateSecretCommand;
use Tecnomanu\UniLogin\Console\CopyViewsCommand;

// Services
use Tecnomanu\UniLogin\Services\UniLoginService;
use Tecnomanu\UniLogin\Services\MagicLinkService;
use Tecnomanu\UniLogin\Services\SessionService;
use Tecnomanu\UniLogin\Services\TokenService;

// Repositories
use Tecnomanu\UniLogin\Repositories\MagicLinkRepository;
use Tecnomanu\UniLogin\Repositories\SessionRepository;
use Tecnomanu\UniLogin\Repositories\UserRepository;

abstract class AbstractServiceProvider extends ServiceProvider
{
    /**
     * The middleware aliases.
     *
     * @var array
     */
    protected $middlewareAliases = [
        'unilogin.success' => SuccessTokenMiddleware::class,
        'unilogin.callback' => CallbackTokenMiddleware::class,
        'unilogin.accept' => AcceptSessionMiddleware::class,
        'unilogin.polling' => PollingTokenMiddleware::class,        
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
        $this->registerUnilogin();
        $this->registerUserRepo();
        $this->registerMagicLink();
        $this->registerSessionServices();
        $this->registerTokenService();
        $this->registerViews();

        $this->registerUniLoginCommand();
        $this->commands('unilogin:create-secret');
        $this->commands('unilogin:copy-views');
    }

    protected function registerViews(){
        $this->loadViewsFrom(__DIR__.'/../views', 'unilogin');
    }

    /**
     * Register the Contracts.
     *
     * @return void
     */
    protected function registerUnilogin(){
        $this->app->bind( UniLoginServiceContract::class, UniLoginService::class);  
    }

    /**
     * Register the Contracts.
     *
     * @return void
     */
    protected function registerUserRepo(){
        $this->app->bind( UserRepositoryContract::class, UserRepository::class);         
    }

     /**
     * Register the MagicLink.
     *
     * @return void
     */
    protected function registerMagicLink(){
        $this->app->bind(MagicLinkServiceContract::class, MagicLinkService::class);
        $this->app->bind(MagicLinkRepositoryContract::class, MagicLinkRepository::class);        
    }

    /**
     * Register the Session Models.
     *
     * @return void
     */
    protected function registerSessionServices(){
        $this->app->bind(SessionServiceContract::class, SessionService::class);
        $this->app->bind(SessionRepositoryContract::class, SessionRepository::class);        
    }
    
    /**
     * Register the Token Service.
     *
     * @return void
     */
    protected function registerTokenService(){
        $this->app->bind(TokenServiceContract::class, TokenService::class);
    }


     /**
     * Register the Artisan command.
     *
     * @return void
     */
    protected function registerUniLoginCommand()
    {
        $this->app->singleton('unilogin:create-secret', function () {
            return new GenerateSecretCommand;
        });

        $this->app->singleton('unilogin:copy-views', function () {
            return new CopyViewsCommand;
        });
    }
}
