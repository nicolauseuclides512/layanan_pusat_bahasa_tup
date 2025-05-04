<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // Tambahkan middleware global Laravel jika perlu
    ];

    protected $middlewareGroups = [
        'web' => [
            // Tambahkan middleware web jika perlu
        ],
        'api' => [
            'throttle:api',
        ],
    ];

    protected $routeMiddleware = [
        'role' => \App\Http\Middleware\CheckRole::class,
    ];
} 