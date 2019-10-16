<?php

namespace Tests\Feature\Console\Commands;

use App\Jobs\UpdateTickets;
use App\UcEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;
use Prophecy\Argument;
use Symfony\Component\Console\Output\OutputInterface;
use Tests\TestCase;

class UpdateTicketsTest extends TestCase
{

    /** @test */
    public function update_tickets_dispatches_a_job_for_each_event(){
        Bus::fake();

        $events = factory(UcEvent::class, 5)->create(['start_date_time' => Carbon::now()->addDay(), 'end_date_time' => Carbon::now()->addDays(2)]);
        $pastEvents = factory(UcEvent::class, 5)->create(['start_date_time' => Carbon::now()->subDay(), 'end_date_time' => Carbon::now()->subDays(2)]);


        $eventIds = $events->pluck('id');
        $this->artisan('update:tickets');

        Bus::assertDispatched(UpdateTickets::class, function($job) use ($eventIds) {
            return $eventIds->contains($job->event->id);
        });

        Bus::assertNotDispatched(UpdateTickets::class, function($job) use  ($eventIds) {
            return !$eventIds->contains($job->event->id);
        });

    }

    /** @test */
    public function update_tickets_outputs_a_confirmation_message(){
        $this->artisan('update:tickets')
            ->expectsOutput('Synchronising tickets');
    }

}
