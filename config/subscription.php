<?php

return [
    'user_model' => App\Models\User::class,
    'models' => [
        'plan' => Raphyabak\Subscription\Models\Plan::class,
        'subscription' => Raphyabak\Subscription\Models\Subscription::class,
    ],
    'table_names' => [
        'plans' => 'plans',
        'subscriptions' => 'subscriptions',
    ],
    'redirects' => [
        'unauthenticated' => 'login',
    ],

    'messages' => [
        'unauthenticated' => 'You need to log in to access this resource.',
        'subscription_required' => 'An active subscription is required to access this resource.',
        'plan_required' => 'You need to be on the :plan plan to access this resource.',
    ],
];
