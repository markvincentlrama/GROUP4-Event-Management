<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'event_name',
        'category',
        'event_date',
        'location',
    ];

    // One event has many participants
    public function participants()
    {
        return $this->hasMany(Eve_part::class, 'event_id');
    }
}
