<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // 5 intentos por minuto por IP en login/forgot/reset
        RateLimiter::for('login', fn(Request $r) =>
            Limit::perMinute(5)->by($r->ip())
        );

        // 3 envíos por minuto por IP en formulario web público
        RateLimiter::for('form', fn(Request $r) =>
            Limit::perMinute(3)->by($r->ip())
        );

        // 120 peticiones por minuto por usuario autenticado, 30 por IP si no autenticado
        RateLimiter::for('api', fn(Request $r) =>
            $r->user()
                ? Limit::perMinute(120)->by($r->user()->id)
                : Limit::perMinute(30)->by($r->ip())
        );
    }
}
