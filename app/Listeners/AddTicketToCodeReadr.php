<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Support\CodeReadr\CodeReadrService;
use ArkonEvent\CodeReadr\ApiClient\Client;
use ArkonEvent\CodeReadr\Exceptions\CodeReadrApiException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Redis;

class AddTicketToCodeReadr implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries = 1000;

    public $queue = 'high';
    /**
     * @var CodeReadrService
     */
    private $codeReadr;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CodeReadrService $codeReadr)
    {
        $this->codeReadr = $codeReadr;
    }

    /**
     * Execute the job.
     *
     * @param Client $client
     * @return void
     */
    public function handle(TicketCreated $event)
    {
        Redis::throttle('codereadr')->allow(50)->every(60)->then(function () use ($event){
            $this->codeReadr->addTicket($event->ticket);
            $event->ticket->on_codereadr = true;
            $event->ticket->save();
        }, function () {
            return $this->release(20);
        });
    }
}
