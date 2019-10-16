<?php

namespace App\Console\Commands;

use App\UcEvent;
use Illuminate\Console\Command;
use Twigger\UnionCloud\API\UnionCloud;

class UpdateTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:tickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all ticket information';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach(UcEvent::toTrack()->get() as $event) {
            dispatch(new \App\Jobs\UpdateTickets($event));
        }
        $this->info('Synchronising tickets');
    }
}
