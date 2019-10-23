<?php

namespace App\Support\CodeReadr;

use App\CodeReadrService;
use App\UcEvent;
use ArkonEvent\CodeReadr\ApiClient\Client;

class CodeReadrServiceFinder
{

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function forEvent(UcEvent $event)
    {
        if($this->serviceExistsFor($event)) {
            return $this->getServiceFor($event);
        }
        return $this->createService($event);
    }

    public function createService(UcEvent $event)
    {
        $database = $this->client->request(Client::SECTION_DATABASES, CLIENT::ACTION_CREATE, [
            'database_name' => $event->name . ' (' . $event->id . ')'
        ]);
        $service = $this->client->request(Client::SECTION_SERVICES, CLIENT::ACTION_CREATE, [
            'validation_method' => 'database',
            'duplicate_value' => 0,
            'period_start_date' => $event->start_date_time->copy()->subHours(24)->toDateString(),
            'period_start_time' => $event->start_date_time->copy()->subHours(24)->toTimeString(),
            'period_end_date' => $event->end_date_time->copy()->addHours(12)->toDateString(),
            'period_end_time' => $event->end_date_time->copy()->addHours(12)->toTimeString(),
            'auto_sync' => 1,
            'database_id' => (string) $database->id,
            'service_name' => $event->name . ' (' . $event->id . ')'
        ]);
        $this->client->request(Client::SECTION_SERVICES, Client::ACTION_ADD_USER_PERMISSION, [
            'service_id' => (int)$service->id,
            'user_id' => 'all'
        ]);
        return CodeReadrService::create([
            'service_id' => $service->id,
            'database_id' => $database->id,
            'event_id' => $event->id
        ]);
    }

    public function getServiceFor(UcEvent $event)
    {
        return CodeReadrService::where('event_id', $event->id)->first();
    }

    public function serviceExistsFor(UcEvent $event)
    {
        return CodeReadrService::where('event_id', $event->id)->count() > 0;
    }
}
