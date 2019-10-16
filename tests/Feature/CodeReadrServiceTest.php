<?php

namespace Tests\Feature;

use App\CodeReadrService;
use App\UcEvent;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CodeReadrServiceTest extends TestCase
{

    /** @test */
    public function it_belongs_to_a_ucevent(){
        Event::fake();
        $event = factory(UcEvent::class)->create();

        $codeReadrService = factory(CodeReadrService::class)->create(['event_id' => $event->id]);

        $this->assertEquals($event->id, $codeReadrService->ucEvent->id);
    }

}
