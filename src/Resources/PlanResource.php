<?php

namespace Raphyabak\Subscription\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'duration' => $this->duration,
            'trial_days' => $this->trial_days,
            'features' => $this->features,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
