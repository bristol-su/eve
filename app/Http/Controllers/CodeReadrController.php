<?php

namespace App\Http\Controllers;

use App\UcEvent;

class CodeReadrController extends Controller
{

    public function index()
    {
        return view('pages.codereadr')
            ->with('tracking', UcEvent::toTrack()->get());
    }

}
