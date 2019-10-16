<?php

namespace Tests\Feature\Listeners;

use App\Events\EventUpdated;
use App\Listeners\UpdateTicketTypes;
use App\Support\UnionCloud\UnionCloud;
use App\TicketType;
use App\UcEvent;
use Illuminate\Contracts\Redis\Connection;
use Illuminate\Events\CallQueuedListener;
use Illuminate\Redis\Limiters\DurationLimiterBuilder;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;
use Twigger\UnionCloud\API\Resource\Event;

class UpdateTicketTypesTest extends TestCase
{

    /** @test */
    public function the_listener_fires_when_an_event_is_updated(){
        Queue::fake();
        $event = factory(UcEvent::class)->create();
        $event->name = "new name";
        $event->save();
        Queue::assertPushed(CallQueuedListener::class, function ($job) {
            return $job->class == UpdateTicketTypes::class;
        });
    }

    /** @test */
    public function it_creates_a_ticket_type_row_per_ticket_type(){
        Queue::fake();
        $ucEventModel = factory(UcEvent::class)->create();
        $unioncloud = $this->prophesize(UnionCloud::class);
        $unioncloud->getEventById($ucEventModel->id)->shouldBeCalled()->willReturn(new Event([
            'ticket_types' => [
                ['id' => 1, 'name' => 'Ticket Type 1'],
                ['id' => 2, 'name' => 'Ticket Type 2'],
                ['id' => 3, 'name' => 'Ticket Type 3'],
            ]
        ]));
        $event = new EventUpdated($ucEventModel);

        $listener = new UpdateTicketTypes($unioncloud->reveal());
        $listener->handle($event);

        $this->assertDatabaseHas('ticket_types', [
            'event_id' => $ucEventModel->id, 'id' => 1, 'name' => 'Ticket Type 1'
        ]);
        $this->assertDatabaseHas('ticket_types', [
            'event_id' => $ucEventModel->id, 'id' => 2, 'name' => 'Ticket Type 2'
        ]);
        $this->assertDatabaseHas('ticket_types', [
            'event_id' => $ucEventModel->id, 'id' => 3, 'name' => 'Ticket Type 3'
        ]);
    }

    /** @test */
    public function it_updates_a_ticket_row_if_row_already_exists(){
        Queue::fake();
        $ucEventModel = factory(UcEvent::class)->create();
        factory(TicketType::class)->create([
            'id' => 1,
            'name' => 'Ticket Type 1',
            'event_id' => $ucEventModel->id
        ]);
        $this->assertDatabaseHas('ticket_types', [
            'event_id' => $ucEventModel->id, 'id' => 1, 'name' => 'Ticket Type 1'
        ]);
        $unioncloud = $this->prophesize(UnionCloud::class);
        $unioncloud->getEventById($ucEventModel->id)->shouldBeCalled()->willReturn(new Event([
            'ticket_types' => [
                ['id' => 1, 'name' => 'Ticket Type 1 - Updated Name'],
            ]
        ]));
        $event = new EventUpdated($ucEventModel);

        $listener = new UpdateTicketTypes($unioncloud->reveal());
        $listener->handle($event);

        $this->assertDatabaseHas('ticket_types', [
            'event_id' => $ucEventModel->id, 'id' => 1, 'name' => 'Ticket Type 1 - Updated Name'
        ]);
    }

}
