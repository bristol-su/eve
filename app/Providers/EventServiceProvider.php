<?php

namespace App\Providers;

use App\Events\EventCreated;
use App\Events\EventUpdated;
use App\Events\ScanCreated;
use App\Events\TicketCreated;
use App\Events\TicketValidityUpdated;
use App\Listeners\AddTicketToCodeReadr;
use App\Listeners\ChangeCodeReadrValidity;
use App\Listeners\RedeemTicketOnUnionCloud;
use App\Listeners\UpdateTicketTypes;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        TicketCreated::class => [
            AddTicketToCodeReadr::class
        ],
        TicketValidityUpdated::class => [
            ChangeCodeReadrValidity::class
        ],
        EventUpdated::class => [
            UpdateTicketTypes::class
        ],
        ScanCreated::class => [
            RedeemTicketOnUnionCloud::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
