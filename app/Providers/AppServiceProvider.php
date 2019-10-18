<?php

namespace App\Providers;

use App\Console\Commands\UpdateICalFeed;
use App\Support\Events\AvailabilityFilter;
use App\Support\Events\Contracts\AvailabilityFilter as AvailabilityFilterContract;
use App\Support\Events\Contracts\EventRepository as EventRepositoryContract;
use App\Support\Events\DatabaseEventRepository;
use App\Support\Events\Filters\RoomOpen;
use App\Support\Events\IcalEventRepository;
use App\Support\ICal\JohnGrogg\Event;
use App\Support\ICal\Contracts\Event as EventContract;
use App\Support\ICal\Contracts\ICal as ICalContract;
use App\Support\ICal\JohnGrogg\ICal;
use ArkonEvent\CodeReadr\ApiClient\Client;
use ICal\ICal as JohnGroggICal;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EventRepositoryContract::class, IcalEventRepository::class);
        $this->app->bind(EventContract::class, Event::class);
        $this->app->bind(ICalContract::class, function($app) {
            return new ICal($app->make(JohnGroggICal::class), config('app.calurl'));
        });

        $this->app->singleton(AvailabilityFilterContract::class, AvailabilityFilter::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro('sortByDate', function ($column = 'created_at', $order = SORT_DESC) {
            /* @var $this Collection */
            return $this->sortBy(function ($datum) use ($column) {
                return strtotime($datum->$column);
            }, SORT_REGULAR, $order == SORT_DESC);
        });

        $this->app->instance(
            Client::class,
            new Client(config('codereadr.key'))
        );

        \App\Support\Events\Facade\AvailabilityFilter::register(new RoomOpen);
    }
}
