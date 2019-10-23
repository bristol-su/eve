<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TermTime extends Model
{

    protected $fillable = [
        'start', 'end'
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'term_time' => 'boolean'
    ];

    public function scopeCurrent(Builder $query)
    {
        $query->where('start', '<=', Carbon::now())
            ->where('end', '>=', Carbon::now());
    }

}
