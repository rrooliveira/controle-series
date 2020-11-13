<?php

namespace App\Listeners;

use App\Events\CriarNovaSerieEvent;
use App\Mail\CriarNovaSerieMail;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EnviarEmailAposCriarNovaSerieListener implements ShouldQueue
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
        //Enviar e-mail para todos os usuários da aplicação
        //$users = User::all();
        //foreach($users as $user) {
            //$mail = new CriarNovaSerieMail($event->nome, $event->qtdTemporadas, $event->qtdEpisodios);
            //Mail::to($user)->queue($mail);
        //}

        //Enviar e-mail somente usuário logado
        $mail = new CriarNovaSerieMail($event->nome, $event->qtdTemporadas, $event->qtdEpisodios);
        Mail::to($event->user)->send($mail);
    }
}
