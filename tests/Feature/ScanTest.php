<?php

namespace Tests\Feature;

use App\Events\ScanCreated;
use App\Scan;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ScanTest extends TestCase
{

    /** @test */
    public function it_dispatches_an_event_on_creation(){
        Event::fake();
        $scan = factory(Scan::class)->create();

        Event::assertDispatched(ScanCreated::class, function($job) use ($scan) {
            return $job->scan->id === $scan->id;
        });
    }

}
