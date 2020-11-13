<?php

namespace App\Providers;

use App\Events\ApagarSerieEvent;
use App\Events\CriarNovaSerieEvent;
use App\Listeners\ApagarCapaListener;
use App\Listeners\EnviarEmailAposCriarNovaSerieListener;
use App\Listeners\GerarLogAposCriarNovaSerieListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CriarNovaSerieEvent::class => [
            EnviarEmailAposCriarNovaSerieListener::class,
            GerarLogAposCriarNovaSerieListener::class
        ],
        /*
        ApagarSerieEvent::class => [
            ApagarCapaListener::class
        ]*/
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
