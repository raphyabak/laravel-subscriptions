<?php

namespace Raphyabak\Subscription\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'duration', 'trial_days', 'features',
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
    ];

    public function subscriptions()
    {
        return $this->hasMany(config('subscription.models.subscription'));
    }

    public function hasFeature(string $feature)
    {
        return in_array($feature, $this->features ?? []);
    }
}
