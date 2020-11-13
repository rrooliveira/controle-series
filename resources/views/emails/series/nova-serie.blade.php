@component('mail::message')
# Nova Série - {{ $nomeSerie }}

# Quantidade Temporadas - {{ $qtdTemporadas }}

# Quantidade Episódios Por Temporada - {{ $qtdEpisodios }}

{{--@component('mail::button', ['url' => ''])--}}
{{--Button Text--}}
{{--@endcomponent--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
