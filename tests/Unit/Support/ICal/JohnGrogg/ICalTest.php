<?php

namespace Tests\Unit\Support\ICal\JohnGrogg;

use App\Support\ICal\Contracts\ICal;
use ICal\Event;
use ICal\ICal as JohnGroggICal;
use Prophecy\Argument;
use Tests\TestCase;

class ICalTest extends TestCase
{

    /** @test */
    public function ical_sets_the_url_from_a_given_url(){
        $icalJG = $this->prophesize(JohnGroggICal::class);
        $icalJG->initUrl('https://someurl.com')->shouldBeCalled();

        $ical = new \App\Support\ICal\JohnGrogg\ICal($icalJG->reveal(), 'https://someurl.com');
    }

    /** @test */
    public function ical_resolves_the_url_from_config(){
        $this->app['config']->set('app.calurl', 'https://someurl.com');

        $icalJG = $this->prophesize(JohnGroggICal::class);
        $icalJG->initUrl(Argument::any())->shouldBeCalled();
        $this->instance(JohnGroggICal::class, $icalJG->reveal());

        $ical = $this->app->make(ICal::class);
    }


    /** @test */
    public function events_returns_all_events_from_the_ical(){
        $icalJG = $this->prophesize(JohnGroggICal::class);
        $icalJG->initUrl('https://someurl.com')->shouldBeCalled();
        $icalJG->events()->shouldBeCalled()->willReturn([]);

        $ical = new \App\Support\ICal\JohnGrogg\ICal($icalJG->reveal(), 'https://someurl.com');

        $this->assertEquals(collect(), $ical->events());
    }

    /** @test */
    public function events_returns_all_events_as_an_event_class_from_the_ical()
    {
        $icalJG = $this->prophesize(JohnGroggICal::class);
        $icalJG->initUrl('https://someurl.com')->shouldBeCalled();
        $icalJG->events()->shouldBeCalled()->willReturn([
            new Event,
            new Event
        ]);

        $ical = new \App\Support\ICal\JohnGrogg\ICal($icalJG->reveal(), 'https://someurl.com');

        $events = $ical->events();
        foreach($events as $event) {
            $this->assertInstanceOf(\App\Support\ICal\Contracts\Event::class, $event);
        }
    }

}
