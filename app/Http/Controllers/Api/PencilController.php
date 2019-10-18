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
        $input = $request->input('in_name', 'pencil');
        return Event::where('summary', 'LIKE', '%'. $input .'%')->get();
    }
}
