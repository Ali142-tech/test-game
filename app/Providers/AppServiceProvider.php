<?php

namespace App\Providers;

use App\Database\Connectors\NeonPostgresConnector;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('db.connector.pgsql', NeonPostgresConnector::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('local')) {
            return;
        }

        $publicDomain = env('RAILWAY_PUBLIC_DOMAIN') ?: env('RAILWAY_STATIC_URL');

        if ($publicDomain) {
            $root = str_starts_with($publicDomain, 'http')
                ? rtrim($publicDomain, '/')
                : 'https://'.rtrim($publicDomain, '/');

            URL::forceRootUrl($root);
        }

        URL::forceScheme('https');
    }
}
