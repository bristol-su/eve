<?php

namespace Tests\Feature\Listeners;

use App\Events\EventCreated;
use App\Listeners\UpdateEventInformation;
use App\Listeners\UpdateTicketTypes;
use App\Support\UnionCloud\UnionCloud;
use App\UcEvent;
use Carbon\Carbon;
use Illuminate\Events\CallQueuedListener;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Twigger\UnionCloud\API\Exception\Resource\ResourceNotFoundException;
use Twigger\UnionCloud\API\Resource\Event;

class UpdateEventInformationTest extends TestCase
{

    /** @test */
    public function it_is_dispatched_when_an_event_is_created(){
        Queue::fake();
        $event = factory(UcEvent::class)->create();
        Queue::assertPushed(CallQueuedListener::class, function ($job) {
            return $job->class == UpdateEventInformation::class;
        });
    }

    /** @test */
    public function it_updates_the_event_in_the_database(){
        \Illuminate\Support\Facades\Event::fake();
        $ucEvent = factory(UcEvent::class)->create();
        $unioncloud = $this->prophesize(UnionCloud::class);
        $unioncloud->getEventById($ucEvent->id)->shouldBeCalled()->willReturn(new Event([
            'name' => 'Event Name',
            'slug' => 'event-slug',
            'description' => 'A description',
            'capacity' => 150,
            'location' => 'here',
            'latitude' => 1.5,
            'longitude' => 1.7,
            'contact_details' => 'Toby Twigger',
            'email' => 'example@example.com',
            'start_date_time' => '10-10-2019 10:00',
            'end_date_time' => '10-10-2019 11:45'
        ]));

        $this->assertDatabaseHas('uc_events', ['id' => $ucEvent->id]);
        $listener = new UpdateEventInformation($unioncloud->reveal());
        $listener->handle(new EventCreated($ucEvent));
        $this->assertDatabaseHas('uc_events', [
            'id' => $ucEvent->id,
            'name' => 'Event Name',
            'slug' => 'event-slug',
            'description' => 'A description',
            'capacity' => 150,
            'location' => 'here',
            'latitude' => 1.5,
            'longitude' => 1.7,
            'contact_details' => 'Toby Twigger',
            'email' => 'example@example.com',
            'start_date_time' => '2019-10-10 10:00:00',
            'end_date_time' => '2019-10-10 11:45:00'
        ]);
    }

    /** @test */
    public function it_throws_an_error_if_the_event_is_not_found(){
        \Illuminate\Support\Facades\Event::fake();
        $this->expectException(ResourceNotFoundException::class);
        $ucEvent = factory(UcEvent::class)->create();
        $unioncloud = $this->prophesize(UnionCloud::class);
        $unioncloud->getEventById($ucEvent->id)->shouldBeCalled()->willThrow(new ResourceNotFoundException());

        $listener = new UpdateEventInformation($unioncloud->reveal());
        $listener->handle(new EventCreated($ucEvent));

    }

}
