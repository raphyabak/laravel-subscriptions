<?php

namespace Raphyabak\Subscription\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Raphyabak\Subscription\Models\Subscription;

class SubscriptionCreated
{
    use Dispatchable;

    public $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }
}
