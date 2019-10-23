<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UcEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Twigger\UnionCloud\API\Exception\Resource\ResourceNotFoundException;
use Twigger\UnionCloud\API\UnionCloud;

class UcEventsController extends Controller
{

    public function search(Request $request)
    {
        return UcEvent::where('name', 'LIKE', '%' . $request->input('search') . '%')
            ->where('end_date_time', '>', Carbon::now()->subHours(12))
            ->get();
    }

    public function track(Request $request, UcEvent $ucEvent)
    {
        $ucEvent->tracking = true;
        $ucEvent->save();
        return $ucEvent;
    }

    public function indexTrack(Request $request)
    {
        return UcEvent::toTrack()->get()->map(function($event) {
            $event->ticket_sold_count = $event->ticketTypes->reduce(function($agg, $ticketType) {
                return $agg + $ticketType->tickets()->where('on_codereadr', true)->count();
            });
            $event->ticket_redeem_count = $event->ticketTypes->reduce(function($agg, $ticketType) {
                return $agg + $ticketType->tickets()->where('redeemed', true)->count();
            });
            return $event;
        });
    }

}
