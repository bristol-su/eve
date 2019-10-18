<?php

namespace App\Http\Controllers;

use App\AirtableView;
use App\UcEvent;

class AirtableViewController extends Controller
{

    public function show(AirtableView $airtableView)
    {
        return view('pages.view')
            ->with('view', $airtableView);
    }

}
