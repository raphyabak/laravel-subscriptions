<?php

namespace Raphyabak\Subscription\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class SubscriptionGateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerGates();
    }

    protected function registerGates()
    {
        Gate::define('has-feature', function ($user, $feature) {
            return $user->hasFeature($feature);
        });

        Gate::define('subscribed-to-plan', function ($user, $planName) {
            $subscription = $user->activeSubscription();
            return $subscription && $subscription->plan->name === $planName;
        });

        Gate::define('is-subscribed', function ($user) {
            return $user->isSubscribed();
        });
    }
}
