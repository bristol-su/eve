<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UcEvent;
use Illuminate\Http\Request;
use Twigger\UnionCloud\API\Exception\Resource\ResourceNotFoundException;
use Twigger\UnionCloud\API\UnionCloud;

class UcEventsController extends Controller
{

    public function index(Request $request, UnionCloud $unionCloud)
    {
        try {
            return array_map(function($event) {
                return $event->getAttributes();
            }, $unionCloud->events()->setPage((int)$request->input('page', 1))->getAll()->get()->toArray());
        } catch (ResourceNotFoundException $e) {
            return [];
        }
    }

    public function track(Request $request)
    {
        return UcEvent::create([
            'id' => $request->input('event_id')
        ]);
    }

}
