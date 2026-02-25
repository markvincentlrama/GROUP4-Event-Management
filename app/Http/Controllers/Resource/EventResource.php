<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray(Request $request): array
{
    return [
        'id' => $this->id,
        'event_name' => $this->event_name,
        'category' => $this->category,
        'event_date' => $this->event_date,
        'location' => $this->location,
        'participants' => $this->participants,
        'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
    ];
}
}