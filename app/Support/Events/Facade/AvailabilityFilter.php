<?php

namespace App\Support\Events\Facade;

use App\Support\Events\Availability;
use Illuminate\Support\Facades\Facade;

/**
 * Class AvailabilityFilter
 * @package App\Support\Events\Facade
 *
 * @method static bool available(Availability $availability)
 */
class AvailabilityFilter extends Facade
{

    public static function getFacadeAccessor()
    {
        return \App\Support\Events\Contracts\AvailabilityFilter::class;
    }

}
