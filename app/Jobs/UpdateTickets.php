<?php

namespace App\Jobs;

use App\Events\TicketValidityUpdated;
use App\Support\UnionCloud\UnionCloud;
use App\Ticket;
use App\UcEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Redis;

class UpdateTickets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $event;

    public $tries = 10;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(UcEvent $event)
    {
        $this->event = $event;
        self::onQueue('updatetickets');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(UnionCloud $unionCloud)
    {
        Redis::throttle('updatetickets')->allow(max(2, min(UcEvent::toTrack()->count(), 20)))->every(60)->then(function() use ($unionCloud) {
            $attendees = $unionCloud->getAttendeesForEvent($this->event->id);
            foreach($attendees as $attendee) {
                $currentTicket = Ticket::where('ticket_number', $attendee->ticket_number)->first();
                if($currentTicket === null) {
                    $parameters = [
                        'forename' => $attendee->forename,
                        'surname' => $attendee->surname,
                        'ticket_type_id' => $attendee->ticket_type_id,
                        'quantity' => $attendee->quantity,
                        'ticket_number' => $attendee->ticket_number,
                        'redeemed' => ($attendee->redeemed === 'false' ? false : true)
                    ];
                    $ticket = Ticket::create($parameters);
                } elseif($attendee->redeemed === 'true' && $currentTicket->redeemed === false) {
                    $currentTicket->redeemed = true;
                    $currentTicket->save();
                    event(new TicketValidityUpdated($currentTicket));
                }
            }
        }, function() {
            $this->release(20);
        });
    }
}
