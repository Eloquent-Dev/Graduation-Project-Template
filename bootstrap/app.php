<?php

use App\Models\ThrottleLog;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (HttpException $e, Request $request){
            if($e->getStatusCode() === 429) {

                $routeMiddlewares = $request->route() ? $request->route()->gatherMiddleware() : [] ;

                $throttleMiddleware = collect($routeMiddlewares)
                ->first(fn($m) => str_contains($m,'throttle')) ?? 'global throttle';
                ThrottleLog::create([
                    'ip_address' => $request->ip(),
                    'url' => substr($request->fullUrl(), 0, 255),
                    'middleware' => substr($throttleMiddleware, 0, 255),
                    'method' => $request->method(),
                    'user_id' => auth()->id(),
                    'user_agent' => $request->userAgent(),
                ]);
            }

            return null;
        });
    })->create();
