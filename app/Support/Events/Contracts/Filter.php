<?php

namespace App\Support\Events\Contracts;

use App\Support\Events\Availability;

abstract class Filter
{

    /**
     * @var Filter
     */
    private $successor = null;

    public function setNext(?Filter $filter = null)
    {
        $this->successor = $filter;
    }

    public function next(Availability $availability)
    {
        if($this->successor === null) {
            return null;
        }
        return $this->successor->unavailable($availability);
    }

    abstract public function unavailable(Availability $availability): ?bool;

}
