<?php

namespace App\Support\Events;

use App\Event;
use App\Support\Events\Contracts\EventRepository;

class DatabaseEventRepository implements EventRepository
{

    public function all()
    {
        return Event::all();
    }


}
