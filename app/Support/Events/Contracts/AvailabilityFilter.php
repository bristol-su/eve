<?php


namespace App\Support\Events\Contracts;


use App\Support\Events\Availability;

interface AvailabilityFilter
{
    public function available(Availability $availability): bool;

    public function register(Filter $filter);
}
