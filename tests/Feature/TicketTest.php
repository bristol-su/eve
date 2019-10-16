<?php

namespace Tests\Feature;

use App\Events\EventCreated;
use App\Events\TicketCreated;
use App\Ticket;
use App\TicketType;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class TicketTest extends TestCase
{

    /** @test */
    public function it_dispatches_an_event_on_creation(){
        Event::fake();

        $ticket = factory(Ticket::class)->create();

        Event::assertDispatched(TicketCreated::class, function($job) use ($ticket) {
            return $job->ticket->id === $ticket->id;
        });
    }

    /** @test */
    public function it_has_a_ticket_type(){
        Event::fake();
        $ticketType = factory(TicketType::class)->create();
        $ticket = factory(Ticket::class)->create(['ticket_type_id' => $ticketType->id]);

        $this->assertEquals($ticketType->id, $ticket->ticketType->id);
    }

}
