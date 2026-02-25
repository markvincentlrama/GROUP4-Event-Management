<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Eve_part extends Model
{
    protected $table = 'event_participant';
    protected $fillable = [
        'event_id',
        'user_id',
    ];
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
