<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use App\Support\Events\AvailabilityFinder;
use App\Support\Events\AvailabilityJoiner;
use App\Support\Events\AvailabilityTuner;
use App\Support\Events\Contracts\EventRepository;
use App\Support\Events\Facade\AvailabilityFilter;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request, AvailabilityFinder $finder)
    {

        $startDateTime = Carbon::parse($request->input('dateFrom'));
        $endDateTime = Carbon::parse($request->input('dateTo'));

        $availabilities = collect();
        $availableSlots = $finder->find(
            $startDateTime, $endDateTime,
            $request->input('hourFrom', 0),
            $request->input('minuteFrom', 0),
            $request->input('hourTo', 0),
            $request->input('minuteTo', 0)
        );

        foreach($request->input('location', []) as $location) {
            $locationAvailabilities = $availableSlots->map(function($availability) use ($location) {
                $availability->location = $location;
                return $availability;
            })->filter(function($availability) {
                return AvailabilityFilter::available($availability);
            })->values();

            $availabilities = $availabilities->concat(
                AvailabilityJoiner::join($locationAvailabilities)
            );
        }

        return $availabilities;

    }
}
