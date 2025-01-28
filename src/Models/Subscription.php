<?php

namespace Raphyabak\Subscription\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id', 'plan_id', 'starts_at', 'ends_at', 'is_active', 'duration',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(config('subscription.user_model'));
    }

    public function plan()
    {
        return $this->belongsTo(config('subscription.models.plan'));
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('ends_at', '>', now());
    }
}
