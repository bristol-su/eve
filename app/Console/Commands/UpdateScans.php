<?php

namespace App\Console\Commands;

use ArkonEvent\CodeReadr\ApiClient\Client;
use Illuminate\Console\Command;

class UpdateScans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:scans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update scans';

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
    public function handle(Client $client)
    {
        dispatch(new \App\Jobs\UpdateScans());
        $this->info('Synchronising Scans');
    }
}
