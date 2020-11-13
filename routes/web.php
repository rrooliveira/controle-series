<?php

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/entrar', 'EntrarController@index');
Route::post('/entrar', 'EntrarController@entrar');
Route::get('/registrar', 'RegistroController@create');
Route::post('/registrar', 'RegistroController@store');

Route::get('/sair', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/entrar');
});


Route::get('/', 'SeriesController@index');
Route::get('/series', 'SeriesController@index')->name('listar_series');

Route::group(['middleware' => 'autenticador'], function (){
    Route::get('/series/criar', 'SeriesController@create')->name('form_criar_serie');
    Route::post('/series/criar', 'SeriesController@store');
    Route::delete('/series/{id}', 'SeriesController@destroy');
    Route::post('/series/{id}/editaNome', 'SeriesController@editaNome');
});

Route::get('/series/{serieId}/temporadas', 'TemporadasController@index');
Route::get('/temporadas/{temporada}/episodios', 'EpisodiosController@index');
Route::post('/temporadas/{temporada}/episodios/assistir', 'EpisodiosController@assistir')->middleware('autenticador');
