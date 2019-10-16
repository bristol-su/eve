<?php


namespace App\Support\ICal\Contracts;


interface Event
{

    public function description();

    public function endDateTime();

    public function createdDateTime();

    public function startDateTime();

    public function location();

    public function organizer();

    public function sequence();

    public function summary();

    public function uid();

}
