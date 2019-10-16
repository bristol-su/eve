<?php

namespace Tests\Unit\Support\ICal\JohnGrogg;

use App\Support\ICal\JohnGrogg\Event;
use Carbon\Carbon;
use ICal\Event as JohnGroggEvent;
use Tests\TestCase;

class EventTest extends TestCase
{

    /** @test */
    public function it_transforms_a_john_grogg_event_to_an_event(){
        $startTime = Carbon::now()->addDay();
        $endtime = Carbon::now()->addDays(2);
        $created = Carbon::now()->subDay();
        $eventJG = new JohnGroggEvent([
            'DESCRIPTION' => 'Some Description',
            'DTEND' => $endtime->toIso8601String(),
            'DTSTAMP' => $created->toIso8601String(),
            'DTSTART' => $startTime->toIso8601String(),
            'LOCATION' => 'Odlum',
            'ORGANIZER' => 'example@example.com',
            'SEQUENCE' => 1,
            'SUMMARY' => 'Some Summary',
            'UID' => 123456789
        ]);

        $event = new Event($eventJG);

        $this->assertEquals('Some Description', $event->description());
        $this->assertEquals($endtime->toIso8601String(), $event->endDateTime()->toIso8601String());
        $this->assertEquals($created->toIso8601String(), $event->createdDateTime()->toIso8601String());
        $this->assertEquals($startTime->toIso8601String(), $event->startDateTime()->toIso8601String());
        $this->assertEquals('Odlum', $event->location());
        $this->assertEquals('example@example.com', $event->organizer());
        $this->assertEquals(1, $event->sequence());
        $this->assertEquals('Some Summary', $event->summary());
        $this->assertEquals(123456789, $event->uid());
    }

}
