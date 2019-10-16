<?php

namespace App\Listeners;

use App\Events\EventCreated;
use App\Support\UnionCloud\UnionCloud;
use App\UcEvent;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Redis;

class UpdateEventInformation implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries = 1000;

    public $queue = 'urgent';

    /**
     * @var UnionCloud
     */
    private $unionCloud;



    public function __construct(UnionCloud $unionCloud)
    {
        $this->unionCloud = $unionCloud;

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EventCreated $event)
    {
        Redis::throttle('events')->allow(20)->every(60)->then(function () use ($event) {
            $ucEvent = $this->unionCloud->getEventById($event->event->id);
            UcEvent::findOrFail($event->event->id)->fill([
                'name' => $ucEvent->name,
                'slug' => $ucEvent->slug,
                'description' => $ucEvent->description,
                'capacity' => $ucEvent->capacity,
                'location' => $ucEvent->location,
                'latitude' => $ucEvent->latitude,
                'longitude' => $ucEvent->longitude,
                'contact_details' => $ucEvent->contact_details,
                'email' => $ucEvent->email,
                'start_date_time' => Carbon::parse($ucEvent->start_date_time),
                'end_date_time' => Carbon::parse($ucEvent->end_date_time),
            ])->save();
        }, function () {
            $this->release(20);
        });
    }

}
