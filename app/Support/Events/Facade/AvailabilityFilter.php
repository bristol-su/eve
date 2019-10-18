<?php

namespace App\Support\Events\Facade;

use Illuminate\Support\Facades\Facade;

class AvailabilityFilter extends Facade
{

    public static function getFacadeAccessor()
    {
        return \App\Support\Events\Contracts\AvailabilityFilter::class;
    }

}
