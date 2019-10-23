<?php

namespace App\Support\Events;

use Illuminate\Support\Collection;

class AvailabilityJoiner
{

    public static function join(Collection $availabilities)
    {
        $joinedAvailabilities = collect();
        $availabilities->sortByDate('from');
        for ($i = 0; $i < $availabilities->count(); $i++) {
            if ($i !== ($availabilities->count() - 1) && $availabilities[$i]->to->eq($availabilities[($i + 1)]->from)) {
                continue;
            }
            $j = $i;
            while ($j !== 0 && $availabilities[$j]->from->eq($availabilities[($j - 1)]->to)) {
                $j--;
            }
            $availability = new Availability($availabilities[$j]->from, $availabilities[$i]->to);
            $availability->location = $availabilities[$i]->location;
            $joinedAvailabilities->push($availability);
        }

        return $joinedAvailabilities;
    }

}
