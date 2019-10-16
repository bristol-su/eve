<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IcalEvent extends Model
{

    protected $fillable = [
        'uid', 'event_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

}
