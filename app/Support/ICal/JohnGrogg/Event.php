<?php

namespace App\Support\ICal\JohnGrogg;

use App\Support\ICal\Contracts\Event as EventContract;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Event implements EventContract, Arrayable, Jsonable
{

    /**
     * @var \ICal\Event
     */
    private $event;

    public function __construct(\ICal\Event $event)
    {
        $this->event = $event;
    }

    public function description()
    {
        return $this->event->description;
    }

    public function endDateTime()
    {
        return Carbon::parse($this->event->dtend);
    }

    public function createdDateTime()
    {
        return Carbon::parse($this->event->dtstamp);
    }

    public function startDateTime()
    {
        return Carbon::parse($this->event->dtstart);
    }

    public function location()
    {
        return $this->event->location;
    }

    public function organizer()
    {
        return $this->event->organizer;
    }

    public function sequence()
    {
        return $this->event->sequence;
    }

    public function summary()
    {
        return $this->event->summary;
    }

    public function uid()
    {
        return $this->event->uid;
    }

    public function toArray()
    {
        return [
            'description' => $this->description(),
            'endDateTime' => $this->endDateTime(),
            'createdDateTime' => $this->createdDateTime(),
            'startDateTime' => $this->startDateTime(),
            'location' => $this->location(),
            'organizer' => $this->organizer(),
            'sequence' => $this->sequence(),
            'summary' => $this->summary(),
            'uid' => $this->uid(),
        ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function __toString()
    {
        return $this->toJson();
    }

}
