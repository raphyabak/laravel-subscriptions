<?php

namespace Raphyabak\Subscription\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'plan' => new PlanResource($this->plan),
            'status' => $this->is_active ? 'active' : 'inactive',
            'start_date' => $this->starts_at,
            'end_date' => $this->ends_at,
            'remaining_days' => now()->diffInDays($this->ends_at, false),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
