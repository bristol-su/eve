<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    protected $fillable = [
        'location',
        'start',
        'end',
        'summary'
    ];

    public function scopeOnBetween(Builder $query, $from, $to)
    {
        $query->where('end', '>', $from)
            ->where('start', '<', $to);
    }

    public function scopeBetweenDates(Builder $query, $from, $to)
    {
        $from = Carbon::parse($from)->startOfDay();
        $to = Carbon::parse($to)->endOfDay();
        $query->where(function($query) use ($from, $to){
            $query->where('start', '<', $to)
                ->where('start', '>', $from);
        })->orWhere(function($query) use ($from, $to){
            $query->where('end', '<', $to)
                ->where('end', '>', $from);
        });
    }

    public function scopeWithName(Builder $query, $name)
    {
        $query->where('summary', 'LIKE', '%'. $name .'%');
    }

    public function scopeWithLocation(Builder $query, $location=[])
    {
        $query->whereIn('location', $location);
    }
}
