<?php

namespace App\Listeners;

use App\Events\EventUpdated;
use App\Support\UnionCloud\UnionCloud;
use App\TicketType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Redis;

class UpdateTicketTypes implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries = 1000;

    public $queue = 'updatetickettypes';


    /**
     * @var UnionCloud
     */
    private $unionCloud;

    public function __construct(UnionCloud $unionCloud)
    {
        $this->unionCloud = $unionCloud;

    }

    public function handle(EventUpdated $event)
    {
        Redis::throttle('events')->allow(20)->every(60)->then(function () use ($event) {
            $ucEvent = $this->unionCloud->getEventById($event->event->id);
            if(is_array($ucEvent->ticket_types)) {
                foreach($ucEvent->ticket_types as $ticketType) {
                    $ticketTypeModel = TicketType::updateOrCreate(
                        ['id' => $ticketType['id']],
                        [
                            'id' => $ticketType['id'],
                            'name' => $ticketType['name'],
                            'event_id' => $event->event->id
                        ]
                    );
                }
            }
        }, function () {
            $this->release(20);
        });
    }

}
