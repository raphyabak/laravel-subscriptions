<?php

namespace Raphyabak\Subscription\Console\Commands;

use Illuminate\Console\Command;
use Raphyabak\Subscription\Models\Subscription;

class CheckSubscriptionStatus extends Command
{
    protected $signature = 'subscription:check-status';
    protected $description = 'Check and update subscription statuses';

    public function handle()
    {
        $expired = Subscription::where('ends_at', '<=', now())
            ->where('is_active', true)
            ->update(['is_active' => false]);

        $this->info("Updated {$expired} expired subscriptions.");
    }
}
