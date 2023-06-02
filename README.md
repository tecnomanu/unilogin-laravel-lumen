# UniLogin

UniLogin is a Laravel/Lumen package that allows users to log in to a web application through a magic link. This means that the user does not need to remember a password to log in, but simply clicks on a link that is sent to their email.

#### Enter on Gitbook Documentation:
https://unilogin.gitbook.io/docs/

## Index

1. [Introduction](#introduction)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Usage](#usage)
5. [API](#api)
6. [Advanced Customization](#advanced-customization)
7. [Error Handling](#error-handling)
8. [Contribute](#contribute)

## Introduction

UniLogin allows you to implement magic link login in your Laravel or Lumen application. This type of login is based on sending a link to the user's email that, when clicked, automatically logs in the user to your application.

## Installation

The installation of UniLogin is very simple. You can install it in a Laravel or Lumen application:

### Laravel

1. Run the following command:

   `composer require tecnomanu/unilogin`

2.  Publish the configuration file and views:
    
    `php artisan vendor:publish --provider="Tecnomanu\UniLogin\LaravelServiceProvider"`

### Lumen

1.  Run the following command:
    
    `composer require tecnomanu/unilogin`
    
2.  Copy the configuration file and views:
    
    `php artisan unilogin:copy-views`

Configuration
-------------

Once the package is installed, you can configure it through the `config/unilogin.php` file or directly in your `.env` file.

*   `UNILOGIN_SECRET`: Secret key to generate the magic links. You can generate it with the `php artisan unilogin:create-secret` command. Default: empty.
*   `UNILOGIN_TOKEN_LIFETIME`: Lifetime of the magic link token in seconds. Default: 900 (15 minutes).
*   `UNILOGIN_CALLBACK_URL`: URL where the application should redirect after a successful login. Default: empty.
*   `UNILOGIN_API_BASE_PATH`: Base path for the API. Default: empty.


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

Usage
-----

1.  Middleware

To use the UniLogin magic link, you need to use the middleware that comes with the package. You can add the middleware in your `web.php` or `api.php` routes file:

```php
Route::get('/login-success', function (Request $request) {     
    // Receive from request "email";

    // Your login logic here. 
    // ...
    // Or use this example
    $user = User::where('email', $request->email)->first();
    Auth::login($user);
    return redirect('/');

})->middleware('unilogin.success');
```

API
---

UniLogin comes with several pre-configured routes that handle the different stages of the magic link login process. Here they are:

*   `POST /unilogin`: Send the magic link to the user's email.
*   `GET /unilogin/polling`: Check if the magic link has been clicked.
*   `GET /unilogin/callback`: Handle the callback from the magic link.
*   `GET /unilogin/error`: Show an error message if the login fails.
*   `GET /unilogin/invalid-session`: Show a message if the session is invalid.
*   `GET /unilogin/success`: Handle a successful login.

Advanced Customization
----------------------

As you progress in the integration and use of the UniLogin package, you may find the need to make adjustments that better suit your project. In this section, we will explore some of the most common ways to customize UniLogin.

1.  Middleware
    
    The UniLogin package comes with a custom middleware: `SuccessTokenMiddleware`. This middleware processes the SUCCESS type tokens and adds the user's email to the request. You might need to customize this middleware, for example, if you need to add more fields to the request.
    
    Here's an example of how you could customize this middleware to add a 'company\_id' field to the request:
    
    ```php
    // SuccessTokenMiddleware.php  //... 
    public function handle(Request $request, Closure $next) {     
        // ...     
        $credentials = $request->get('credentials');      
        
        // Merge additional fields to the request     
        
        $request->merge([
            'email' => $credentials['email'], 
            'company_id' => $credentials['company_id'] 
        // New field     
        ]);          
        return $next($request); 
    } 
    //...
    ```
    
2.  Views
    
    Views are another area where you might want to customize UniLogin. The error, invalid session and success views can be customized according to the needs of your project. You can copy the views into your application and make the necessary changes using the `unilogin:copy-views` command.
    

Error Handling
--------------

Error handling is essential for providing a smooth and consistent user experience. The UniLogin package comes with a built-in error handling system, which throws different types of exceptions depending on the error occurred.

In most cases, the UniLogin package returns a JSON response with a description of the error and an HTTP status code. For example, if a token has expired, it will return a JSON response with the status 'error' and the corresponding message.

If you need a more custom error handling system, you could consider editing the functions that throw the exceptions in the middleware.

Contribute
----------

If you want to contribute to the development of UniLogin, you can follow these steps:

1.  Fork the repository on GitHub.
2.  Clone your fork to your local machine.
3.  Create a new branch in your local repository.
4.  Make your changes in the new branch.
5.  Push the changes to your fork on GitHub.
6.  Open a pull request from your fork to the main UniLogin repository.
7.  After review and any necessary discussions, your changes may be merged into the main branch.

Before opening a pull request, please make sure to check the existing issues and pull requests to avoid duplication. Also, please follow the existing coding standards and conventions.

Thank you for your interest in contributing to UniLogin!