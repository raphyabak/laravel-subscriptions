<?php

namespace Raphyabak\Subscription\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSubscription
{
    public function handle(Request $request, Closure $next, $plan = null)
    {
        $user = $request->user();

        if (!$user) {
            return $this->unauthorizedResponse($request);
        }

        if (!$user->isSubscribed()) {
            return $this->forbiddenResponse($request, 'subscription_required');
        }

        if ($plan && !$user->activeSubscription()->plan->is($plan)) {
            return $this->forbiddenResponse($request, 'plan_required', ['plan' => $plan]);
        }

        return $next($request);
    }

    private function unauthorizedResponse(Request $request)
    {
        $message = trans('subscription::messages.unauthenticated');
        return $request->expectsJson()
        ? response()->json(['error' => $message], 401)
        : redirect()->route(config('subscription.redirects.unauthenticated'));
    }

    private function forbiddenResponse(Request $request, string $messageKey, array $replace = [])
    {
        $message = trans("subscription::messages.$messageKey", $replace);

        return $request->expectsJson()
        ? response()->json(['error' => $message], 403)
        : abort(403, $message);
    }
}
