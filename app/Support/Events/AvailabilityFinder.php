<?php

namespace App\Support\Events;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class AvailabilityFinder
{

    public function find(Carbon $startDateTime, Carbon $endDateTime, $hourFrom, $minuteFrom, $hourTo, $minuteTo, $minuteInterval=60)
    {
        $startDateTime = $startDateTime->startOfDay();
        $endDateTime = $endDateTime->endOfDay();
        $availabilities = collect();
        $currentDate = $startDateTime->copy();
        while($currentDate->lt($endDateTime)) {
            $currentDate->setTime($hourFrom, $minuteFrom);
            $dailyEndTime = $currentDate->copy()->setTime($hourTo, $minuteTo);
            while($currentDate->lt($dailyEndTime)) {
                $availableFrom = $currentDate->copy();
                $currentDate->addMinutes($minuteInterval);
                $availabilities->push(new Availability($availableFrom, $currentDate->copy()));
            }
            $currentDate->addDay();
        }

        return $availabilities;
    }

}
