<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $guarded = [];

    public $incrementing = false;

    public function ucEvent()
    {
        return $this->belongsTo(UcEvent::class, 'event_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
