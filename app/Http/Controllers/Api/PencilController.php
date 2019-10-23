<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use App\Support\Events\AvailabilityFinder;
use App\Support\Events\Contracts\EventRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PencilController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        return Event::withName($request->input('in_name', 'pencil'))
            ->withLocation($request->input('location', []))
            ->betweenDates($request->input('dateFrom'), $request->input('dateTo'))
            ->get()
            ->filter(function($event) use ($request) {
                $from = $request->input('hourFrom', 0) . ':' . $request->input('minuteFrom', 0) . ':00';
                $to = $request->input('hourTo', 23) . ':' . $request->input('minuteTo', 59) . ':59';
                return ($event->start->toTimeString() >= $from && $event->start->toTimeString() <= $to)
                    || ($event->end->toTimeString() >= $from && $event->end->toTimeString() <= $to);
            });

    }
}
