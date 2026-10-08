<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'aspfiy/paga/verify/webhook/process',
            'aspfiy/palmpay/verify/webhook/process',
            'nekpay/payment/webhook',
            'nekpay/withdrawal/webhook',
            'kkpay/deposit/webhook/confirm',
            'kkpay/withdrawal/webhook/confirm'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
