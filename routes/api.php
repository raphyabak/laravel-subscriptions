<?php

use Illuminate\Support\Facades\Route;
use Raphyabak\Subscription\Http\Controllers\SubscriptionApiController;

Route::middleware(config('subscription.api.middleware'))->group(function () {
    Route::prefix(config('subscription.route_prefix'))->group(function () {
        Route::get('/plans', [SubscriptionApiController::class, 'indexPlans']);
        Route::post('/subscribe', [SubscriptionApiController::class, 'subscribe']);
        Route::get('/status', [SubscriptionApiController::class, 'status']);
    });

    Route::middleware('throttle_by_subscription')
        ->post('/webhook', [SubscriptionApiController::class, 'handleWebhook']);
});
