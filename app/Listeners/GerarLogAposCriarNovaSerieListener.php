<?php

namespace App\Listeners;

use App\Events\CriarNovaSerieEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class GerarLogAposCriarNovaSerieListener implements ShouldQueue
{
    public $queue = 'series';
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  CriarNovaSerieEvent  $event
     * @return void
     */
    public function handle(CriarNovaSerieEvent $event)
    {
        Log::info('Gerando Log Após Criar Série - ' . $event->nome);
        Log::debug('Testando Debug');
    }
}
