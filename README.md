# Laravel Subscriptions Package Documentation

## Introduction

The **Laravel Subscriptions** package offers a straightforward and flexible solution for managing subscriptions in your Laravel application. With this package, you can:

- Create subscription plans.
- Manage user subscriptions.
- Control access to application features based on subscription status.

## Installation

To get started, install the package via Composer:

```bash
composer require raphyabak/laravel-subscriptions
```

## Configuration

After installation, publish the configuration file to customize the package settings:

```bash
php artisan vendor:publish --provider="Raphyabak\Subscription\Providers\SubscriptionServiceProvider" --tag="subscription-config"
```

This command generates a `config/subscription.php` file. You can modify the package settings in this file to suit your application.

### Configuration Options

Here are the key options you can configure in `config/subscription.php`:

1. **User Model**:

   - Specify the fully qualified class name of your User model.
   - Default: `App\Models\User`

2. **Models**:

   - Override the default models if needed:
     - `plan`: Model for subscription plans. Default: `Raphyabak\Subscription\Models\Plan`
     - `subscription`: Model for user subscriptions. Default: `Raphyabak\Subscription\Models\Subscription`

3. **Table Names**:
   - Customize the table names used by the package:
     - `plans`: Table for subscription plans. Default: `plans`
     - `subscriptions`: Table for user subscriptions. Default: `subscriptions`

#### Example Configuration:

```php
return [
    'user_model' => App\Models\CustomUser::class,
    'models' => [
        'plan' => App\Models\CustomPlan::class,
        'subscription' => App\Models\CustomSubscription::class,
    ],
    'tables' => [
        'plans' => 'custom_plans',
        'subscriptions' => 'custom_subscriptions',
    ],
];
```

> **Note:** If you change the table names, remember to update your database migrations accordingly.

## Database Migrations

Run the included database migrations to create the necessary tables:

```bash
php artisan migrate
```

This command creates the following tables:

- `plans`: Stores subscription plans.
- `subscriptions`: Stores user subscriptions.

If you customized the table names in the configuration, the migrations will reflect those changes.

## Usage

### Setting Up the User Model

To enable subscription features, add the `HasSubscriptions` trait to your User model.

1. Import and apply the trait:

```php
use Raphyabak\Subscription\Traits\HasSubscriptions;

class User extends Authenticatable
{
    use HasSubscriptions;

    // Additional user model code...
}
```

2. If your User model is customized or resides in a different namespace, update the `user_model` option in `config/subscription.php`:

```php
return [
    'user_model' => App\Models\CustomUser::class,
];
```

The `HasSubscriptions` trait provides useful methods, such as:

- `subscriptions()`: Retrieve all subscriptions for the user.
- `activeSubscription()`: Retrieve the user's active subscription.
- `isSubscribed()`: Check if the user has an active subscription.
- `subscribeTo(Plan $plan, $duration = null)`: Subscribe the user to a plan.
- `cancelSubscription()`: Cancel the user's active subscription.
- `hasFeature($feature)`: Check if the user's active subscription includes a specific feature.

### Creating Subscription Plans

You can create subscription plans programmatically or through your admin interface. Here's an example:

```php
use Raphyabak\Subscription\Models\Plan;

$plan = Plan::create([
    'name' => 'Pro Plan',
    'description' => 'Access to all features',
    'price' => 29.99,
    'duration' => 30, // Duration in days
    'trial_days' => 7, // Trial period in days
    'features' => ['feature1', 'feature2', 'feature3'],
]);
```

### Managing User Subscriptions

#### Subscribe a User to a Plan

```php
$user = User::find(1);
$plan = Plan::find(1);

// Subscribe the user for the plan's default duration
$subscription = $user->subscribeTo($plan);

// Subscribe the user for a custom duration (e.g., 7 days)
$subscription = $user->subscribeTo($plan, 7);

// Subscribe the user for a specific period (e.g., monthly, yearly)
$subscription = $user->subscribeTo($plan, 30); // Monthly
$subscription = $user->subscribeTo($plan, 365); // Yearly
```

#### Check If a User Is Subscribed

```php
if ($user->isSubscribed()) {
    // The user has an active subscription
}
```

#### Retrieve Active Subscription

```php
$activeSubscription = $user->activeSubscription();
```

#### Cancel a Subscription

```php
$user->cancelSubscription();
```

### Access Control with Gates

The package provides gates for managing access to features and plans. These gates are registered automatically.

#### Available Gates

1. `has-feature`: Check if the user has a specific feature.
2. `subscribed-to-plan`: Check if the user is subscribed to a specific plan.
3. `is-subscribed`: Check if the user has any active subscription.

#### Using Gates in Controllers

```php
if (Gate::allows('has-feature', 'premium_content')) {
    // User has access to premium content
}

if (Gate::allows('subscribed-to-plan', 'pro')) {
    // User is subscribed to the 'Pro' plan
}

if (Gate::allows('is-subscribed')) {
    // User has an active subscription
}
```

#### Using Gates in Blade Templates

```php
@can('has-feature', 'premium_content')
    <div>Access to premium content</div>
@endcan

@can('subscribed-to-plan', 'pro')
    <div>Welcome to the Pro Plan!</div>
@endcan

@can('is-subscribed')
    <div>Thank you for subscribing!</div>
@else
    <div>Please subscribe to access more features.</div>
@endcan
```

### Middleware for Access Control

The package includes middleware for route-level access control:

1. `subscribed`: Ensures the user has an active subscription.
2. `feature`: Ensures the user's subscription includes a specific feature.
3. `throttle_by_subscription`: Throttles requests based on the user's subscription.

#### Example Usage

```php
// Require any active subscription
Route::middleware(['subscribed'])->group(function () {
    // Routes for subscribed users
});

// Require subscription to a specific plan
Route::middleware(['subscribed:pro'])->group(function () {
    // Routes for 'Pro' plan users
});

// Require access to a specific feature
Route::middleware(['feature:premium_feature'])->group(function () {
    // Routes for users with the 'premium_feature'
});
```

### Scheduled Subscription Status Checks

The package includes a `CheckSubscriptionStatus` Artisan command to automatically update subscription statuses:

```bash
php artisan subscription:check-status
```

To automate this, schedule the command in `App\Console\Kernel`:

```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('subscription:check-status')->daily();
}
```

## Events

The package emits the following events:

- `SubscriptionCreated`: Triggered when a new subscription is created.
- `SubscriptionCancelled`: Triggered when a subscription is canceled.

You can listen to these events to execute custom actions.

## Contributing

Contributions are welcome! Feel free to submit a pull request to improve the package.

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
