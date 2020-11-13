<?php

namespace App\Listeners;

use App\Events\ApagarSerieEvent;
use App\Services\SerieService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApagarCapaListener implements ShouldQueue
{
    public $queue = 'series';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ApagarSerieEvent  $event
     * @return void
     */
    public function handle(ApagarSerieEvent $event)
    {
        $serieService = new SerieService();
        $serieService->apagarCapa($event->serie);
    }
}
