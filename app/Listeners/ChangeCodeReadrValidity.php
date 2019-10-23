<?php

namespace App\Listeners;

use App\Events\TicketValidityUpdated;
use App\Support\CodeReadr\CodeReadrService;
use App\Ticket;
use ArkonEvent\CodeReadr\ApiClient\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;

class ChangeCodeReadrValidity implements ShouldQueue
{

    public $tries = 1000;

    public $queue = 'high';

    /**
     * @var CodeReadrService
     */
    private $codeReadrService;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CodeReadrService $codeReadrService)
    {
        $this->codeReadrService = $codeReadrService;
    }

    /**
     * Execute the job.
     *
     * @param Client $client
     * @return void
     */
    public function handle(TicketValidityUpdated $event)
    {
        Redis::throttle('codereadr')->allow(50)->every(60)->then(function () use ($event) {
            $this->codeReadrService->updateTicketValidity($event->ticket, !$event->ticket->redeemed);
            $event->ticket->on_codereadr = true;
            $event->ticket->save();
        }, function () {
            return $this->release(20);
        });
    }

}
