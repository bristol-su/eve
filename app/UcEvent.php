<?php

namespace App;

use App\Events\EventCreated;
use App\Events\EventUpdated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UcEvent extends Model
{
    protected $guarded = [];

    public $incrementing = false;

    protected $dispatchesEvents = [
        'created' => EventCreated::class,
        'updated' => EventUpdated::class
    ];

    protected $casts = [
        'start_date_time' => 'datetime',
        'end_date_time' => 'datetime'
    ];

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class, 'event_id');
    }

    public function codeReadrService()
    {
        return $this->hasOne(CodeReadrService::class, 'event_id');
    }

    public function scopeToTrack(Builder $query)
    {
        $query->where('end_date_time', '>', Carbon::now()->subHours(5));
    }

}
