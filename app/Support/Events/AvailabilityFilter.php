<?php

namespace App\Support\Events;

use App\Support\Events\Contracts\Filter;

class AvailabilityFilter implements Contracts\AvailabilityFilter
{
    /**
     * @var Filter[]
     */
    private $filters = [];

    public function available(Availability $availability): bool
    {
        $filter = $this->getChain();
        $result = $filter->unavailable($availability);
        return !($result??false);
    }

    public function getChain()
    {
        if(count($this->filters) === 0) {
            throw new \Exception('No filters registered');
        }
        $filters = $this->filters;
        for ($i = 0; $i < (count($filters) - 1); $i++) {
            $filters[$i]->setNext($filters[$i + 1]);
        }
        return $filters[0];
    }

    public function register(Filter $filter)
    {
        $this->filters[] = $filter;
    }
}
