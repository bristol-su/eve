<?php

namespace App;

use App\Events\ScanCreated;
use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    protected $dispatchesEvents = [
        'created' => ScanCreated::class
    ];

    protected $fillable = [
        'ticket_number', 'redeemed_on_uc'
    ];

}
