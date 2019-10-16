<?php

namespace App\Support\CodeReadr;

use App\Ticket;
use App\UcEvent;
use ArkonEvent\CodeReadr\ApiClient\Client;
use ArkonEvent\CodeReadr\Exceptions\CodeReadrApiException;
use Illuminate\Support\Collection;

class CodeReadrService
{
    /**
     * @var CodeReadrServiceFinder
     */
    private $finder;

    /**
     * @var Client
     */
    private $client;

    public function __construct(CodeReadrServiceFinder $finder, Client $client)
    {
        $this->finder = $finder;
        $this->client = $client;
    }

    public function updateTicketValidity(Ticket $ticket, bool $validity)
    {
        $service = $this->finder->forEvent($ticket->ticketType->ucEvent);

        $this->client->request(Client::SECTION_DATABASES, 'upsertvalue', [
            'database_id' => (string) $service->database_id,
            'value' => $ticket->ticket_number,
            'validity' => ($validity?0:1),
            'response' => $ticket->forename . ' ' . $ticket->surname . ' (' . $ticket->ticketType->name . ')'
        ]);
    }

    public function addTicket(Ticket $ticket)
    {
        $service = $this->finder->forEvent($ticket->ticketType->ucEvent);

        try {
            $this->client->request(Client::SECTION_DATABASES, 'addvalue', [
                'database_id' => (string) $service->database_id,
                'value' => $ticket->ticket_number,
                'validity' => ($ticket->redeemed?0:1),
                'response' => $ticket->forename . ' ' . $ticket->surname . ' (' . $ticket->ticketType->name . ')'
            ]);
        } catch (CodeReadrApiException $e) {
            if($e->getMessage() !== 'Duplicate value.') {
                throw $e;
            }
        }
    }

    public function scansForEvents(Collection $events)
    {
        $services = $events->map(function($event) {
            return $event->codeReadrService->service_id;
        });
        return $this->client->request('scans', 'retrieve', [
            'service_id' => $events->join(', ')
        ]);
    }

}
