<?php

namespace App\Support\Events\Filters;

use App\Support\Events\Availability;
use App\Support\Events\Contracts\Filter;
use Carbon\Carbon;

class RoomOpen extends Filter
{

    public function isInvalid(Availability $availability): ?bool
    {
//        return false;
        $startTime = Carbon::create($availability->to->year, $availability->to->month, $availability->to->day, 2, 0);
        $endTime = Carbon::create($availability->to->year, $availability->to->month, $availability->to->day, 4, 0);

        // If start time before the end time and end time after the start time its invalid
//        if(!$availability->from->eq($availability->to)) {
//            dd(($availability->from->lt($startTime) && $availability->to->lt($startTime)),
//                ($availability->to->gt($endTime) && $availability->from->gt($endTime)));
//        }
        if( ($availability->from->lt($startTime) && $availability->to->lt($startTime))
        || ($availability->to->gt($endTime) && $availability->from->gt($endTime))) {
            return true;
        }

        return parent::next($availability);
//        if($availability->from->)
        // Invalid if start is before 2am and end after 2am

        // Return true (invalid) if availability falls between 2 and 4 am
        // This is if the start date is not earlier than 2, or the end date is not later than 4
        // If between 2am and 4am, cancel
        // Get if we're currently in a term time or not
        // Get the first relevant opening times/closing times
        // Is availability in these?
    }
}
