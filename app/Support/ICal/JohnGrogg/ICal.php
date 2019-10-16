<?php

namespace App\Support\ICal\JohnGrogg;

use App\Support\ICal\Contracts\Event as EventContract;
use App\Support\ICal\Contracts\ICal as ICalReaderContract;
use ICal\ICal as JohnGroggICal;
use Illuminate\Support\Facades\Cache;

class ICal implements ICalReaderContract
{

    /**
     * @var JohnGroggICal
     */
    private $ICal;

    public function __construct(JohnGroggICal $ICal, string $url)
    {
        $this->ICal = $ICal;
        $this->ICal->initUrl($url);
    }

    /**
     * Return all events from an ical
     *
     * @return mixed
     */
    public function events()
    {
        return Cache::remember('ICalGetAllEvents', 3600, function() {
            $events = collect();
            foreach($this->ICal->events() as $event) {
                $events->push(
                    app()->make(EventContract::class, ['event' => $event])
                );
            }
            return $events;
        });
    }
}
