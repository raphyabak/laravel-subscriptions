<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::prefix(config('subscription.route_prefix'))->group(function () {
        Route::get('/', [\Raphyabak\Subscription\Http\Controllers\SubscriptionController::class, 'index'])
            ->name('subscriptions.index');

        Route::get('/upgrade', [\Raphyabak\Subscription\Http\Controllers\SubscriptionController::class, 'upgrade'])
            ->name('subscriptions.upgrade');
    });
});
