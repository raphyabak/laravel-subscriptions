<?php

namespace Raphyabak\Subscription\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests;

class ThrottleBySubscription extends ThrottleRequests
{
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        if ($user = $request->user()) {
            $plan = $user->activeSubscription?->plan;
            $maxAttempts = config("subscription.api.throttle.plans.{$plan->name}", $maxAttempts);
        }

        return parent::handle($request, $next, $maxAttempts, $decayMinutes, $prefix);
    }

    protected function buildResponse($key, $maxAttempts)
    {
        return response()->json([
            'error' => [
                'code' => 429,
                'message' => 'API rate limit exceeded',
            ],
        ], 429);
    }
}
