<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use App\Support\Events\AvailabilityFinder;
use App\Support\Events\Contracts\EventRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $startDateTime = Carbon::parse($request->input('dateFrom'))->setTime(0, 0, 0, 0);
        $endDateTime = Carbon::parse($request->input('dateTo'))->setTime(23, 59, 59, 9999999);
        $events = Event::where('start', '>=', $startDateTime)
            ->where('end', '<=', $endDateTime)
            ->get()
            ->filter(function($event) use ($request) {
                return count($request->input('location', [])) === 0
                    || in_array($event->location, $request->input('location', []));
            });
        $availabilityFinder = new AvailabilityFinder();
        return $availabilityFinder->find($startDateTime, $endDateTime, $events)->filter(function($availability) use ($request) {
            return (!$request->has('timeFrom') || $availability->from->format('HH:mm') < $request->input('timeFrom'))
                && (!$request->has('timeTo') || $availability->to->format('HH:mm') > $request->input('timeTo'));
        })->values();
    }
}
