<?php

namespace App\Support\Events;

use Illuminate\Support\Collection;

class AvailabilityFinder
{

    public function find($startDateTime, $endDateTime, $events)
    {
        $locationGroupedEvents = $events->sortByDate('start', SORT_ASC)->groupBy('location');
        $availabilities = new Collection;
        foreach($locationGroupedEvents as $location => $locationEvents) {
            $availableAfter = null;
            foreach($locationEvents as $event) {
                if($availableAfter !== null) {
                    $availabilities->push(
                        new Availability($location, $availableAfter, $event->start)
                    );
                }
                $availableAfter = $event->end;
            }
        }
        return $availabilities;
    }

}
