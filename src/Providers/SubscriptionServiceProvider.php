<?php

namespace Raphyabak\Subscription\Providers;

use Illuminate\Support\ServiceProvider;

class SubscriptionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/subscription.php', 'subscription');
        $this->app->register(SubscriptionGateServiceProvider::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->publishes([
            __DIR__ . '/../../config/subscription.php' => config_path('subscription.php'),
        ], 'subscription-config');

        $this->app['router']->aliasMiddleware('subscribed', \Raphyabak\Subscription\Http\Middleware\CheckSubscription::class);
        $this->app['router']->aliasMiddleware('feature', \Raphyabak\Subscription\Http\Middleware\CheckFeature::class);
        $this->app['router']->aliasMiddleware('throttle_by_subscription', \Raphyabak\Subscription\Http\Middleware\ThrottleBySubscription::class);

        $this->commands([
            \Raphyabak\Subscription\Console\Commands\CheckSubscriptionStatus::class,
        ]);
    }
}
