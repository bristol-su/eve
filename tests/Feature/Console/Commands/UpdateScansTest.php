<?php

namespace Tests\Feature\Console\Commands;

use App\Event;
use App\Jobs\UpdateScans;
use App\Jobs\UpdateTickets;
use App\UcEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;
use Prophecy\Argument;
use Symfony\Component\Console\Output\OutputInterface;
use Tests\TestCase;

class UpdateScansTest extends TestCase
{

    /** @test */
    public function update_scans_dispatches_a_job(){
        Bus::fake();

        $this->artisan('update:scans');

        Bus::assertDispatched(UpdateScans::class, 1);

    }

    /** @test */
    public function update_tickets_outputs_a_confirmation_message(){
        Bus::fake();
        $this->artisan('update:scans')
            ->expectsOutput('Synchronising Scans');
    }

}
