<?php

namespace App\Console\Commands;

use App\IcalEvent;
use App\Support\Events\Contracts\EventRepository;
use App\Support\ICal\Contracts\Event;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class UpdateICalFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:ical';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the events database with the ical feed';
    /**
     * @var EventRepository
     */
    private $eventRepository;

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
     * For each ical event, we have to
     *      if in icalevent table, and updated_at equal, do nothing
     *      if in icalevent table, and updated_at not equal, update event table and updated_at in icalevent table
     *      if not in icalevent table, add to events and icalevent table
     * Delete any events and ical events not called up
     * @return mixed
     */
    public function handle()
    {
        /** @var Event[] $events */
        $events = app(EventRepository::class)->all();
        $icalEventsUsed = [];
        foreach($events as $event) {
            dd($event);
            $icalEvent = IcalEvent::where('uid', $event->uid())->with('event')->first();
            if($icalEvent) {
                $icalEventsUsed[] = $icalEvent->id;
                if($event->createdDateTime()->gt($icalEvent->updated_at)) {
                    $icalEvent->event()->updateOrCreate([
                        'location' => $event->location(),
                        'start' => $event->startDateTime(),
                        'end' => $event->endDateTime(),
                        'summary' => $event->summary()
                    ]);
                }
            } else {
                IcalEvent::create([
                    'uid' => $event->uid(),
                    'event_id' => \App\Event::create([
                        'location' => $event->location(),
                        'start' => $event->startDateTime(),
                        'end' => $event->endDateTime(),
                        'summary' => $event->summary()
                    ])->id
                ]);
            }
        }

        IcalEvent::where('id', 'NOT IN', $icalEventsUsed)->delete();
    }
}
