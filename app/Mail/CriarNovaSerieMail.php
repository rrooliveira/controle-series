<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CriarNovaSerieMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nome;
    public $qtdTemporadas;
    public $qtdEpisodios;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $nome, int $qtdTemporadas, int $qtdEpisodios)
    {
        $this->nome = $nome;
        $this->qtdTemporadas = $qtdTemporadas;
        $this->qtdEpisodios = $qtdEpisodios;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.series.nova-serie',
            [
                'nomeSerie' => $this->nome,
                'qtdTemporadas' => $this->qtdTemporadas,
                'qtdEpisodios' => $this->qtdEpisodios
            ]);
    }
}
