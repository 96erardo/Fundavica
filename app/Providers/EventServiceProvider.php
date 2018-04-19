<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // POST EVENTS
        'App\Events\UpdatedPost' => ['App\Listeners\StoreUpdateHistory'],
        'App\Events\HiddenPost' => ['App\Listeners\StoreHiddenHistory'],
        'App\Events\ShowPost' => ['App\Listeners\StoreShownHistory'],
        // USER EVENTS

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
