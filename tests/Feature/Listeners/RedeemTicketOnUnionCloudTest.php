<?php

namespace Tests\Feature\Listeners;

use App\Events\EventCreated;
use App\Events\ScanCreated;
use App\Listeners\RedeemTicketOnUnionCloud;
use App\Listeners\UpdateEventInformation;
use App\Scan;
use App\Support\UnionCloud\UnionCloud;
use App\Ticket;
use App\TicketType;
use App\UcEvent;
use Illuminate\Events\CallQueuedListener;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Twigger\UnionCloud\API\Resource\Event;

class RedeemTicketOnUnionCloudTest extends TestCase
{

    /** @test */
    public function it_fires_on_scan_created(){
        Queue::fake();
        $event = factory(Scan::class)->create();
        Queue::assertPushed(CallQueuedListener::class, function ($job) {
            return $job->class == RedeemTicketOnUnionCloud::class;
        });
    }

    /** @test */
    public function it_redeems_a_ticket_if_not_already_redeemed(){
        \Illuminate\Support\Facades\Event::fake();
        $unioncloud = $this->prophesize(UnionCloud::class);

        $ucEvent = factory(UcEvent::class)->create();
        $ticketType = factory(TicketType::class)->create(['event_id' => $ucEvent->id]);
        $ticket = factory(Ticket::class)->create(['ticket_type_id' => $ticketType->id, 'redeemed' => false]);
        $scan = factory(Scan::class)->create(['ticket_number' => $ticket->ticket_number]);

        $unioncloud->redeemTicket($ucEvent->id, $scan->ticket_number)->shouldBeCalled();

        $listener = new RedeemTicketOnUnionCloud($unioncloud->reveal());
        $listener->handle(new ScanCreated($scan));

    }

    /** @test */
    public function it_does_not_redeem_a_ticket_if_already_redeemed(){
        \Illuminate\Support\Facades\Event::fake();
        $unioncloud = $this->prophesize(UnionCloud::class);

        $ucEvent = factory(UcEvent::class)->create();
        $ticketType = factory(TicketType::class)->create(['event_id' => $ucEvent->id]);
        $ticket = factory(Ticket::class)->create(['ticket_type_id' => $ticketType->id, 'redeemed' => true]);
        $scan = factory(Scan::class)->create(['ticket_number' => $ticket->ticket_number]);

        $unioncloud->redeemTicket($ucEvent->id, $scan->ticket_number)->shouldNotBeCalled();

        $listener = new RedeemTicketOnUnionCloud($unioncloud->reveal());
        $listener->handle(new ScanCreated($scan));
    }

    /** @test */
    public function it_updates_the_database_when_redeemed(){
        \Illuminate\Support\Facades\Event::fake();
        $unioncloud = $this->prophesize(UnionCloud::class);

        $ucEvent = factory(UcEvent::class)->create();
        $ticketType = factory(TicketType::class)->create(['event_id' => $ucEvent->id]);
        $ticket = factory(Ticket::class)->create(['ticket_type_id' => $ticketType->id, 'redeemed' => false]);
        $scan = factory(Scan::class)->create(['ticket_number' => $ticket->ticket_number]);
        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'redeemed' => false
        ]);

        $unioncloud->redeemTicket($ucEvent->id, $scan->ticket_number)->shouldBeCalled();

        $listener = new RedeemTicketOnUnionCloud($unioncloud->reveal());
        $listener->handle(new ScanCreated($scan));

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'redeemed' => true
        ]);
    }

}
