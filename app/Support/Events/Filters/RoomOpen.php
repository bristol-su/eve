<?php

namespace App\Support\Events\Filters;

use App\RoomOpeningTime;
use App\Support\Events\Availability;
use App\Support\Events\Contracts\Filter;
use App\TermTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RoomOpen extends Filter
{

    public function unavailable(Availability $availability): ?bool
    {
        $termTime = (TermTime::current()->first()->term_time??false);
        $openingTimes = RoomOpeningTime::where('location', $availability->location)->where('term_time', $termTime)->first();
        if($openingTimes !== null && !$this->fullyBetweenTimes($openingTimes->open, $openingTimes->shuts, $availability)) {
            return true;
        }
        return parent::next($availability);
    }

    public function fullyBetweenTimes($open, $shut, Availability $availability)
    {
        return $availability->from->toTimeString() >= $open && $availability->to->toTimeString() >= $open
            && $availability->from->toTimeString() <= $shut && $availability->to->toTimeString() <= $shut;
    }
}
