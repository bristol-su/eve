<?php

namespace App;

use App\Events\TicketCreated;
use App\Events\TicketValidityUpdated;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = [];

    protected $casts = [
        'redeemed' => 'boolean'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TicketCreated::class
    ];

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }

}
