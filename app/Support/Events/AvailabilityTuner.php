<?php

namespace App\Support\Events;

use App\Support\Events\Facade\AvailabilityFilter as AvailabilityFilterFacade;
use Illuminate\Support\Collection;

class AvailabilityTuner
{

    public function tune(Collection $availabilities)
    {
        $tunedAvailabilities = collect();
        $increment = 60;
        foreach($availabilities as $availability) {

            if(AvailabilityFilterFacade::isInvalid($availability)) {
                // Move the start time forward
                $earlyAvailability = new Availability($availability->location, $availability->from->copy(), $availability->to->copy());
                while($earlyAvailability->to->gt($earlyAvailability->from)) {
                    $earlyAvailability->to->subMinutes($increment);
                    if(!AvailabilityFilterFacade::isInvalid($earlyAvailability)) {
                        $tunedAvailabilities->push($earlyAvailability);
                        break;
                    }
                }

                // Move the start time forward
                $lateAvailability = new Availability($availability->location, $availability->from->copy(), $availability->to->copy());
                while($lateAvailability->from->lt($lateAvailability->to)) {
                    $lateAvailability->from->addMinutes($increment);
                    if(!AvailabilityFilterFacade::isInvalid($lateAvailability)) {
                        $tunedAvailabilities->push($lateAvailability);
                        break;
                    }
                }
            } else {
                $tunedAvailabilities->push($availability);
            }
        }

        return $tunedAvailabilities;
    }

}
