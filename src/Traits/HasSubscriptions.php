<?php

namespace Raphyabak\Subscription\Traits;

use Raphyabak\Subscription\Events\SubscriptionCreated;
use Raphyabak\Subscription\Models\Plan;

trait HasSubscriptions
{
    public function subscriptions()
    {
        return $this->hasMany(config('subscription.models.subscription'));
    }

    public function activeSubscription()
    {
        return $this->subscriptions()->active()->first();
    }

    public function isSubscribed()
    {
        return !is_null($this->activeSubscription());
    }

    public function subscribeTo(Plan $plan, $duration = null)
    {
        $subscription = $this->subscriptions()->create([
            'plan_id' => $plan->id,
            'starts_at' => now(),
            'ends_at' => now()->addDays($duration ?? $plan->duration),
            'is_active' => true,
            'duration' => $duration ?? $plan->duration,
        ]);

        event(new SubscriptionCreated($subscription));

        return $subscription;
    }

    public function cancelSubscription()
    {
        if ($subscription = $this->activeSubscription()) {
            $subscription->update(['is_active' => false]);
            event(new \Raphyabak\Subscription\Events\SubscriptionCancelled($subscription));
        }
    }

    public function hasFeature($feature)
    {
        $subscription = $this->activeSubscription();
        return $subscription && $subscription->plan->hasFeature($feature);
    }
}
