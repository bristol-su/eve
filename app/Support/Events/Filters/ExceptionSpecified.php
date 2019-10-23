<?php

namespace App\Support\Events\Filters;

use App\DateException;
use App\RoomOpeningTime;
use App\Support\Events\Availability;
use App\Support\Events\Contracts\Filter;
use App\TermTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ExceptionSpecified extends Filter
{

    public function unavailable(Availability $availability): ?bool
    {
        if(DateException::between($availability->from, $availability->to)->count() > 0) {
            return true;
        }
        return parent::next($availability);
    }

}
