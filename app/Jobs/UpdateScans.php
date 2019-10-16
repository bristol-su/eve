<?php

namespace App\Jobs;

use App\Scan;
use App\Support\CodeReadr\CodeReadrService;
use App\UcEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Redis;
use Twigger\UnionCloud\API\UnionCloud;

class UpdateScans implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    public function __construct()
    {
        self::onQueue('updatescans');
    }

    public function handle(CodeReadrService $codeReadr)
    {
        // TODO If more than 2 jobs, clear queue

        Redis::throttle('updatescans')->allow(1)->every(20)->then(function() use ($codeReadr) {
            $scans = $codeReadr->scansForEvents(UcEvent::toTrack()->get());
            foreach($scans->scan as $scan) {
                if(Scan::where('ticket_number', $scan->tid)->count() === 0) {
                    Scan::create(['ticket_number' => $scan->tid]);
                }
            }
        }, function() {
            $this->release(20);
        });
    }
}
