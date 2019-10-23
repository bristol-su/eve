<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DateException extends Model
{
    protected $fillable = [
        'from', 'to', 'location'
    ];

    protected $casts = [
        'from' => 'datetime',
        'to' => 'datetime'
    ];

    public function scopeBetween(Builder $query, $from, $to)
    {
        $query->where('to', '>', $from)
            ->where('from', '<', $to);
    }
}
