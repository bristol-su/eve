<?php

namespace App\Support\Events\Filters;

use App\Event;
use App\RoomOpeningTime;
use App\Support\Events\Availability;
use App\Support\Events\Contracts\Filter;
use App\TermTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EventNotScheduled extends Filter
{

    public function unavailable(Availability $availability): ?bool
    {
        if(Event::onBetween($availability->from, $availability->to)->where('location', $availability->location)->count() > 0) {
            return true;
        }
        return parent::next($availability);
    }
}
