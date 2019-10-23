<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomOpeningTime extends Model
{
    protected $fillable = [
        'open', 'shuts', 'location', 'term_time'
    ];

    protected $casts = [
        'open' => 'time',
        'shuts' => 'time',
        'term_time' => 'boolean'
    ];
}
