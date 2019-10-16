<?php

namespace App\Listeners;

use App\Events\ScanCreated;
use App\Support\UnionCloud\UnionCloud;
use App\Ticket;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;

class RedeemTicketOnUnionCloud implements ShouldQueue
{

    /**
     * @var UnionCloud
     */
    private $unionCloud;

    public $tries = 1000;

    public $queue = 'high';
    /**
     * Create the event listener.
     *
     * @return void
     */
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
    public function handle(ScanCreated $event)
    {
        $ticket = Ticket::where('ticket_number', $event->scan->ticket_number)->first();
        if($ticket !== null && !$ticket->redeemed) {
            Redis::throttle('redeem')->allow(20)->every(60)->then(function () use ($ticket) {
                $this->unionCloud->redeemTicket($ticket->ticketType->ucEvent->id, $ticket->ticket_number);
                $ticket->redeemed = true;
                $ticket->save();
            }, function () {
                return $this->release(20);
            });
        }
    }

}
