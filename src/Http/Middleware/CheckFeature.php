<?php

namespace Raphyabak\Subscription\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckFeature
{
    public function handle(Request $request, Closure $next, string $feature)
    {
        $subscription = $request->user()->activeSubscription();

        if (!$subscription || !$subscription->plan->hasFeature($feature)) {
            return $request->expectsJson()
            ? response()->json(['error' => "Feature $feature not available"], 403)
            : redirect()->route(config('subscription.redirects.unauthorized'));
        }

        return $next($request);
    }
}
