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
            'database_id' => (string) $database->id,
            'service_name' => $event->name . ' (' . $event->id . ')'
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
