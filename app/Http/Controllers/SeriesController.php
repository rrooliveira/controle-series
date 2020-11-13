<?php

namespace App\Http\Controllers;

use App\Episodio;
use App\Events\CriarNovaSerieEvent;
use App\Http\Requests\SeriesFormRequest;
use App\Mail\CriarNovaSerieMail;
use App\Mail\Teste;
use App\Serie;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
use App\Services\SerieService;
use App\Temporada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $series = Serie::query()
            ->orderBy('nome')
            ->get();
        $mensagem = $request->session()->get('mensagem');

        return view('series.index', compact('series', 'mensagem'));
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request, SerieService $serieService)
    {
        $arquivoCapa = null;

        if ($request->hasFile('capa')) {
            $arquivoCapa = $request->file('capa')->store('series');
        }

        $serie = $serieService->criarSerie(
            $request->nome,
            $request->qtd_temporadas,
            $request->ep_por_temporada,
            $arquivoCapa
        );

        event(new CriarNovaSerieEvent($request->nome, $request->qtd_temporadas, $request->ep_por_temporada, $arquivoCapa, Auth::user()));

        $request->session()
            ->flash(
                'mensagem',
                "Série {$serie->id} e suas temporadas e episódios criados com sucesso {$serie->nome}"
            );

        return redirect()->route('listar_series');
    }

    public function destroy(Request $request, SerieService $serieService)
    {
        $nomeSerie = $serieService->removerSerie($request->id);
        $request->session()
            ->flash(
                'mensagem',
                "Série $nomeSerie removida com sucesso"
            );
        return redirect()->route('listar_series');
    }

    public function editaNome(int $id, Request $request)
    {
        $serie = Serie::find($id);
        $novoNome = $request->nome;
        $serie->nome = $novoNome;
        $serie->save();
    }
}
