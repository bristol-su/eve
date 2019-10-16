<?php

namespace App\Support\UnionCloud;

class UnionCloud
{

    /**
     * @var \Twigger\UnionCloud\API\UnionCloud
     */
    private $unionCloud;

    public function __construct(\Twigger\UnionCloud\API\UnionCloud $unionCloud)
    {
        $this->unionCloud = $unionCloud;
    }

    public function getEventById($id)
    {
        return $this->unionCloud->events()->getByID($id)->get()->first();
    }

    public function redeemTicket($eventId, $ticketNumber)
    {
        $this->unionCloud->eventTickets()->redeem($eventId, $ticketNumber);
    }

    public function getAttendeesForEvent($eventId)
    {
        $attendees = collect();

        $resources = $this->unionCloud->eventAttendees()->paginate()->forEvent($eventId);
        $pages = $resources->getResponse()->getTotalPages();
        $attendees = collect($resources->get()->toArray());
        for($i = 2; $i<=$pages;$i++) {
            $resources = $this->unionCloud->eventAttendees()->paginate()->setPage($i)->forEvent($eventId)->get();
            $attendees = $attendees->merge($resources->toArray());
        }
        return $attendees;
    }
}
