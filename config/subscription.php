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
    'route_prefix' => 'subscriptions',
    'redirects' => [
        'unauthenticated' => 'login',
        'inactive' => 'subscriptions.index',
        'unauthorized' => 'subscriptions.upgrade',
    ],
    'api' => [
        'enabled' => true,
        'middleware' => ['api', 'auth:api'],
        'throttle' => [
            'enabled' => true,
            'default' => 60,
            'plans' => [
                'basic' => 100,
                'pro' => 1000,
                'enterprise' => null,
            ],
        ],
    ],
];
