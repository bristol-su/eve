<?php

namespace App\Support\Events;

use App\Support\Events\Contracts\EventRepository;
use App\Support\ICal\Contracts\ICal;

class IcalEventRepository implements EventRepository
{

    /**
     * @var ICal
     */
    private $ical;

    public function __construct(ICal $ical)
    {
        $this->ical = $ical;
    }

    public function all()
    {
        return $this->ical->events();
    }
}
