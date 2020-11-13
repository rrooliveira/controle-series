<?php


namespace App\Services;


use App\Episodio;
use App\Events\ApagarSerieEvent;
use App\Jobs\ApagarCapaJob;
use App\Serie;
use App\Temporada;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SerieService
{
    public function criarSerie(string $nomeSerie, int $qtdTemporadas, int $epPorTemporada, ?string $capa): Serie
    {
        DB::beginTransaction();
        $serie = Serie::create(['nome' => $nomeSerie, 'capa' => $capa]);
        $this->criaTemporadas($qtdTemporadas, $epPorTemporada, $serie);
        DB::commit();

        return $serie;
    }

    /**
     * @param int $qtdTemporadas
     * @param int $epPorTemporada
     * @param $serie
     */
    private function criaTemporadas(int $qtdTemporadas, int $epPorTemporada, Serie $serie): void
    {
        for ($i = 1; $i <= $qtdTemporadas; $i++) {
            $temporada = $serie->temporadas()->create(['numero' => $i]);

            $this->criaEpisodios($epPorTemporada, $temporada);
        }
    }

    /**
     * @param int $epPorTemporada
     * @param \Illuminate\Database\Eloquent\Model $temporada
     */
    private function criaEpisodios(int $epPorTemporada, Temporada $temporada): void
    {
        for ($j = 1; $j <= $epPorTemporada; $j++) {
            $temporada->episodios()->create(['numero' => $j]);
        }
    }

    public function removerSerie(int $serieId): string
    {
        $nomeSerie = '';
        DB::transaction(function () use ($serieId, &$nomeSerie) {
            $serie = Serie::find($serieId);
            $serieObj = (object)$serie->toArray();
            $nomeSerie = $serie->nome;

            $this->removerTemporadas($serie);
            $serie->delete();

            //Event / Listener
            //event(new ApagarSerieEvent($serieObj));

            //Job
            ApagarCapaJob::dispatch($serieObj)->onQueue('series');
        });

        return $nomeSerie;
    }

    /**
     * @param $serie
     */
    private function removerTemporadas(Serie $serie): void
    {
        $serie->temporadas->each(function (Temporada $temporada) {
            $this->removerEpisodios($temporada);
            $temporada->delete();
        });
    }

    /**
     * @param Temporada $temporada
     */
    private function removerEpisodios(Temporada $temporada): void
    {
        $temporada->episodios->each(function (Episodio $episodio) {
            $episodio->delete();
        });
    }

    /**
     * @param $serie
     */
    public function apagarCapa(object $serie): void
    {
        if ($serie->capa) {
            Storage::disk()->delete($serie->capa);
        }
    }
}
