<?php

namespace Tests\Feature;

use App\Ticket;
use App\TicketType;
use App\UcEvent;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class TicketTypeTest extends TestCase
{

    /** @test */
    public function it_has_a_unioncloud_event(){
        Event::fake();
        $event = factory(UcEvent::class)->create();
        $ticketType = factory(TicketType::class)->make(['event_id' => $event->id]);

        $this->assertEquals($event->id, $ticketType->ucEvent->id);
    }

    /** @test */
    public function it_has_many_tickets(){
        Event::fake();
        $ticketType = factory(TicketType::class)->make();
        $tickets = factory(Ticket::class, 20)->make();
        $ticketType->tickets()->saveMany($tickets);
        $ticketTypeTickets  =$ticketType->tickets;
        foreach($tickets as $ticket) {
            $this->assertEquals(
                $ticket->id, $ticketTypeTickets->shift()->id
            );
        }
    }

}
