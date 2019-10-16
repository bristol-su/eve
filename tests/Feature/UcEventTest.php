<?php

namespace Tests\Feature;

use App\CodeReadrService;
use App\Events\EventCreated;
use App\Events\EventUpdated;
use App\TicketType;
use App\UcEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UcEventTest extends TestCase
{
    /** @test */
    public function it_has_many_ticket_types(){
        Event::fake();
        $ticketTypes = factory(TicketType::class, 5)->make();
        $ucEvent = factory(UcEvent::class)->create();
        $ucEvent->ticketTypes()->saveMany($ticketTypes);

        $ucEventTicketTypes = $ucEvent->ticketTypes;
        foreach($ucEventTicketTypes as $ticketType) {
            $this->assertEquals(
                $ticketType->id, $ticketTypes->shift()->id
            );
        }
    }

    /** @test */
    public function it_has_a_codereadr_service(){
        Event::fake();
        $codereadrService = factory(CodeReadrService::class)->make();
        $ucEvent = factory(UcEvent::class)->create();
        $ucEvent->codeReadrService()->save($codereadrService);

        $this->assertTrue(
            $codereadrService->is(
                $ucEvent->codeReadrService
            )
        );
    }

    /** @test */
    public function toTrack_returns_all_events_which_are_in_the_future_or_finished_less_than_5_hours_ago(){
        Event::fake();
        $futureEvents = factory(UcEvent::class, 5)->create(['start_date_time' => Carbon::now()->addDay(),'end_date_time' => Carbon::now()->addDays(2)]);
        $edgeEvents = factory(UcEvent::class, 4)->create(['start_date_time' => Carbon::now()->subHours(7),'end_date_time' => Carbon::now()->subHours(4)->subMinutes(59)]);
        $pastEvents = factory(UcEvent::class, 10)->create(['start_date_time' => Carbon::now()->subDays(2),'end_date_time' => Carbon::now()->subDay()]);

        $trackingEvents = UcEvent::toTrack()->get();
        foreach($futureEvents as $event) {
            $this->assertEquals(
                $event->id, $trackingEvents->shift()->id
            );
        }
        foreach($edgeEvents as $event) {
            $this->assertEquals(
                $event->id, $trackingEvents->shift()->id
            );
        }
        $this->assertEmpty($trackingEvents);

    }

    /** @test */
    public function created_fires_a_created_event(){
        Event::fake();
        $event = factory(UcEvent::class)->create();
        Event::assertDispatched(EventCreated::class, 1);
    }

    /** @test */
    public function updated_fires_an_updated_event(){
        Event::fake();
        $event = factory(UcEvent::class)->create();
        $event->name = "New Name";
        $event->save();
        Event::assertDispatched(EventUpdated::class, 1);

    }
}
