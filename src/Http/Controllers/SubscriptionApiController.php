<?php

namespace Raphyabak\Subscription\Http\Controllers;

use Illuminate\Http\Request;
use Raphyabak\Subscription\Models\Plan;
use Raphyabak\Subscription\Resources\PlanResource;
use Raphyabak\Subscription\Resources\SubscriptionResource;

class SubscriptionApiController extends Controller
{
    public function indexPlans()
    {
        return PlanResource::collection(Plan::all());
    }

    public function subscribe(Request $request, Plan $plan)
    {
        $request->validate([
            'payment_token' => 'required|string',
        ]);

        // Process payment here
        $subscription = $request->user()->subscribeTo($plan);

        return new SubscriptionResource($subscription);
    }

    public function status(Request $request)
    {
        return new SubscriptionResource(
            $request->user()->activeSubscription()
        );
    }

    public function handleWebhook(Request $request)
    {
        // Implement webhook handling logic
        return response()->json(['status' => 'received']);
    }
}
