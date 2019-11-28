<?php

namespace App\Support\Events;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Availability implements Arrayable, Jsonable
{

    public $location;
    /**
     * @var Carbon
     */
    public $from;
    public $to;
    public $pencil = false;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function location()
    {
        return $this->location;
    }

    public function from()
    {
        return $this->from->toIso8601String();
    }

    public function to()
    {
        return $this->to->toIso8601String();
    }


    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'location' => $this->location(),
            'from' => $this->from(),
            'to' => $this->to(),
            'pencil' => $this->pencil
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), 0);
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
