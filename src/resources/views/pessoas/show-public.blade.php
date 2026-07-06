@extends('layouts.app')

@section('titulo', $pessoa->nome)

@section('conteudo')

    <style>
        .topicos {
            border-left: solid 10px #a0d6fa;
        }

        .topicos:hover {
            transition-duration: 0.5s;
            border-left: solid 10px #13669c;
        }

        .botao-form {

            background-color: white
        }


        .botao-form:hover {

            background-color: black;
        }

        .avaliacoes {

            box-shadow: none;
        }

        .avaliacoes:hover {

            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
    </style>

    <div class=" mt-4 mb-4 mx-4">

        <div class="clearfix">

            {{-- Exibe o iamgem principal da pessoa se existir, ou uma imagem padrão --}}
            @php
                $imagem_pessoa = $pessoa->images->firstWhere('pivot.principal', true);
            @endphp

            @if ($imagem_pessoa)
                <img style="max-width: 250px" src="{{ asset('storage/' . $imagem_pessoa->caminho) }}"
                    alt="{{ $imagem_pessoa->nome }}" class="float-md-start mb-3 mx-md-3 rounded"
                    title="{{ $imagem_pessoa->nome }}">
            @else
                <img style="max-width: 250px" src="{{ asset('imagens/sem-poster.jpg') }}" alt="Sem poster" title="Sem poster"
                    class="float-md-start mb-3 mx-md-3 rounded">
            @endif

            <p>
            <h3>{{ $pessoa->nome }}</h3>
            </p>
            <strong>Nacionalidade: </strong> {{ $pessoa->nacionalidade }} <br>
            <strong>Gênero: </strong> {{ $pessoa->genero }} <br>
            <strong>Data de nascimento: </strong>
            {{ \Carbon\Carbon::parse($pessoa->data_nascimento)->format('d/m/Y') }} <br>
            <br>
            <strong>Biografia: </strong> {{ $pessoa->biografia }} <br> <br>
            <strong>Profissão(ões): </strong>{{ implode(', ', $profissoes) }}
        </div>

        <hr>

        @isset($pessoa->actor->movies)
            <div class="mb-4">
                <h4 class="topicos p-2">Atuou em</h4>

                @foreach ($pessoa->actor->movies as $filme)
                    @include('partials.div-de-filmes-pagina-detalhes-pessoas')
                @endforeach
            </div>

            <hr>
        @endisset

        @isset($pessoa->director->movies)
            <div class="mb-4">
                <h4 class="topicos p-2">Dirigiu</h4>


                @foreach ($pessoa->director->movies as $filme)
                    @include('partials.div-de-filmes-pagina-detalhes-pessoas')
                @endforeach
            </div>

            <hr>
        @endisset

        @isset($pessoa->writer->movies)
            <div class="mb-4">
                <h4 class="topicos p-2">Escreveu</h4>

                @foreach ($pessoa->writer->movies as $filme)
                    @include('partials.div-de-filmes-pagina-detalhes-pessoas')
                @endforeach
            </div>

            <hr>
        @endisset

        @isset($pessoa->producer->movies)
            <div class="mb-4">
                <h4 class="topicos p-2">Produziu</h4>
                @foreach ($pessoa->producer->movies as $filme)
                    @include('partials.div-de-filmes-pagina-detalhes-pessoas')
                @endforeach
            </div>

            <hr>
        @endisset

        <div class="mb-4">
            <h4 class="topicos p-2">Fotos</h4>

            @foreach ($pessoa->images as $imagem)
                <a href="/imagens-p/{{ $imagem->id }}">
                    <img style="max-width: 250px" src="{{ asset('storage/' . $imagem->caminho) }}"
                        alt="{{ $imagem->nome }}" class="float mb-3 mx-1 rounded" title="{{ $imagem->nome }}">
                </a>
            @endforeach
        </div>

    </div>
@endsection
