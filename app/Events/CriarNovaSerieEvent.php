<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CriarNovaSerieEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $nome;
    public $qtdTemporadas;
    public $qtdEpisodios;
    public $capa;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $nome, int $qtdTemporadas, int $qtdEpisodios, ?string $capa, User $user)
    {
        $this->nome = $nome;
        $this->qtdTemporadas = $qtdTemporadas;
        $this->qtdEpisodios = $qtdEpisodios;
        $this->capa = $capa;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
