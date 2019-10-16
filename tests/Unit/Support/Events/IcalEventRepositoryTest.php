<?php

namespace Tests\Unit\Support\Events;

use App\Support\Events\IcalEventRepository;
use App\Support\ICal\Contracts\ICal;
use App\User;
use Tests\TestCase;

class IcalEventRepositoryTest extends TestCase
{

    /** @test */
    public function all_retrieves_all_events_from_a_calendar_feed(){
        $ical = $this->prophesize(ICal::class);
        $ical->events()->shouldBeCalled()->willReturn([]);
        $repository = new IcalEventRepository($ical->reveal());
        $this->assertEquals([], $repository->all());
    }

}
