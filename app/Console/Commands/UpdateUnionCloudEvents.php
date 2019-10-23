<?php

namespace App\Console\Commands;

use App\Support\UnionCloud\UnionCloud;
use App\UcEvent;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Twigger\UnionCloud\API\Exception\Resource\ResourceNotFoundException;

class UpdateUnionCloudEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:uc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update UnionCloud Events';

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
    public function handle(UnionCloud $unionCloud)
    {
        $page = Cache::get(UpdateUnionCloudEvents::class . '.page', 1);
        try {
            $events = $unionCloud->getAllEvents($page);
            foreach($events as $event) {
                UcEvent::updateOrCreate(
                    ['id' => $event->id],
                    [
                        'id' => $event->id,
                        'name' => $event->name,
                        'slug' => $event->slug,
                        'description' => $event->description,
                        'capacity' => $event->capacity,
                        'location' => $event->location,
                        'latitude' => $event->latitude,
                        'longitude' => $event->longitude,
                        'contact_details' => $event->contact_details,
                        'email' => $event->email,
                        'start_date_time' => Carbon::parse($event->start_date_time),
                        'end_date_time' => Carbon::parse($event->end_date_time),
                ]);
            }
            // For each event, save it in the DB or update it
            Cache::put(UpdateUnionCloudEvents::class . '.page', $page + 1, 20);
        } catch (ResourceNotFoundException $ex) {
            Cache::put(UpdateUnionCloudEvents::class . '.page', 1, 20);
        }
    }
}
