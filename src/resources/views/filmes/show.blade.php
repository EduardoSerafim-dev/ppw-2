@extends('layouts.app')

@section('titulo', 'Filme - ' . $filme->nome)

@section('conteudo')

    <style>
        .topicos {
            border-left: solid 10px #a0d6fa;
            border-bottom: solid 1px #000000;
        }

        .topicos:hover {
            transition-duration: 0.5s;
            border-left: solid 10px #13669c;
        }
    </style>

    <div style="margin-top: 5%; margin-bottom: 3%">
        <h1 class="d-flex justify-content-center mt-4 mb-4">{{ $filme->nome }}</h1>
    </div>

    <div class="card mt-4 mb-4 mx-4">
        <div class="row g-0">
            <div class="col-md-2">
                {{-- Exibe o poster se existir, ou uma imagem padrão --}}
                @php
                    $poster = $filme->images->firstWhere('pivot.poster', true);
                @endphp

                @if ($poster)
                    <img src="{{ asset('storage/' . $poster->caminho) }}" alt="Poster de {{ $filme->nome }}"
                        class="img-fluid rounded w-10" title="Poster de {{ $filme->nome }}">
                @else
                    <img src="{{ asset('imagens/sem-poster.jpg') }}" alt="Sem poster" title="Sem poster"
                        class="img-fluid rounded w-10">
                @endif
            </div>
            <div class="col-md-10">
                <div class="card-body">
                    <p class="card-text"><strong>Sinopse: </strong> {{ $filme->sinopse }}</p>
                    <small>
                        <strong>Duração:</strong> {{ $filme->duracao }} minutos <br>
                        <strong>Classificação:</strong> {{ $filme->classificacao }} <br>
                        <strong>Data de lançamento:</strong>
                        {{ \Carbon\Carbon::parse($filme->data_lancamento)->format('d/m/Y') }} <br>
                        <strong>Gênero(s):</strong>
                        @foreach ($filme->genres as $genero)
                            {{ $genero->nome }}
                        @endforeach
                        <br>
                    </small>
                    <p class="mt-2"><strong>Avaliação:</strong> Estrelas</p>
                </div>
            </div>
        </div>
    </div>

    <h5 class="topicos mb-4 mx-4 p-2">Gêneros</h5>
    <h5 class="topicos mb-4 mx-4 p-2">Direção</h5>
    <h5 class="topicos mb-4 mx-4 p-2">Produção</h5>
    <h5 class="topicos mb-4 mx-4 p-2">Escritores</h5>
    <h5 class="topicos mb-4 mx-4 p-2">Estudio</h5>

    <h3 style="margin-left: 10%" class="mb-4">Elenco</h3>

    <h3 style="margin-left: 10%" class="mb-4">Fotos</h3>

    @foreach ($avaliacoes as $av)
        <div class="card mb-2">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <strong>{{ $av->user->name }}</strong>

                    <span class="badge bg-primary">
                        {{ $av->nota }}/5
                    </span>
                </div>

                <p class="mb-0">
                    {{ $av->descricao }}
                </p>

                <small class="text-muted">
                    {{ $av->created_at->diffForHumans() }}
                </small>
            </div>
        </div>
    @endforeach

@endsection
