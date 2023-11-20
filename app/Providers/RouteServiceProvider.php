<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::prefix('api')
                ->group(function () {
                    Route::prefix('user')
                        ->group(function () {
                            Route::prefix('auth')
                                ->name('.auth')
                                ->group(base_path('routes/api/user/auth.php'));
                            Route::prefix('product')
                                ->name('.product')
                                ->group(base_path('routes/api/user/product.php'));
                        });
                    Route::prefix('supplier')
                        ->name('.supplier')
                        ->group(function () {
                            Route::prefix('auth')
                                ->name('.auth')
                                ->group(base_path('routes/api/supplier/auth.php'));
                            Route::middleware('api.supplier')
                                ->prefix('product')
                                ->name('.product')
                                ->group(base_path('routes/api/supplier/product.php'));
                        });

                });

        });

    }
}
