<?php

namespace Tests\Feature\Support\Events;

use App\Support\Events\AvailabilityFinder;
use Carbon\Carbon;
use Tests\TestCase;

class AvailabilityFinderTest extends TestCase
{

    /** @test */
    public function it_creates_availabilities(){
        $finder = new AvailabilityFinder();
        $start = Carbon::create(2019, 10, 10);
        $end = Carbon::create(2019, 10, 11);

        $availabilities = $finder->find($start, $end, 10, 00, 13, 00);
    }

}
