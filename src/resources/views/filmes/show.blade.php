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

    <div class="clearfix mt-4 mb-4 mx-4">

        {{-- Exibe o poster se existir, ou uma imagem padrão --}}
        @php
            $poster = $filme->images->firstWhere('pivot.poster', true);
        @endphp

        @if ($poster)
            <img src="{{ asset('storage/' . $poster->caminho) }}" alt="Poster de {{ $filme->nome }}"
                class="col-md-2 float-md-start mb-3 mx-md-3 rounded" title="Poster de {{ $filme->nome }}">
        @else
            <img src="{{ asset('imagens/sem-poster.jpg') }}" alt="Sem poster" title="Sem poster"
                class="col-md-6 float-md-end mb-3 ms-md-3 img-fluid rounded w-10">
        @endif

        <p>
        <h3>{{ $filme->nome }}</h3>
        </p>
        <p class="mt-2 "><i class="bi bi-star-fill text-warning"></i> 7,5/10</p>
        <small>
            <strong>Classificação:</strong> {{ $filme->classificacao }} <br>
            <strong>Data de lançamento: </strong>{{ \Carbon\Carbon::parse($filme->data_lancamento)->format('d/m/Y') }}
            <br><br>
        </small>
        <p><strong>Sinopse: </strong> {{ $filme->sinopse }}</p>
        </p>
        <p>
            And yet, here you are, still persevering in reading this placeholder text, hoping for some more insights, or
            some hidden easter egg of content. A joke, perhaps. Unfortunately, there’s none of that here. Lorem ipsum dolor
            sit amet consectetur adipisicing elit. Facilis dolorum iste illum aperiam minima. Corporis accusamus aut sequi,
            expedita fuga, vitae cupiditate quae magnam quo beatae minus, voluptas iusto nisi. Lorem ipsum dolor sit amet
            consectetur adipisicing elit. Quia numquam iure corrupti ullam. Quas, expedita! Placeat, iure, ipsa voluptates
            ducimus tenetur necessitatibus repellendus aliquam voluptatum facilis deleniti cumque totam alias.
        </p>

        <p>
            <strong>Gêneros: </strong>
            @foreach ($filme->genres as $genero)
                {{ $genero->nome }}
            @endforeach
        </p>
    </div>

    <hr>

    <div class="mb-4">
        <h4 class="topicos p-2">Direção, Roteiro e Produção</h4>

        <strong class="p-4">Diretor(es):
        </strong>{{ $filme->directors->map(fn($diretor) => $diretor->person->nome)->implode(', ') }}<br>

        <strong class="p-4">Roteirista(s):
        </strong>{{ $filme->writers->map(fn($escritor) => $escritor->person->nome)->implode(', ') }}<br>

        <strong class="p-4">Produtor(es):
        </strong>{{ $filme->producers->map(fn($produtor) => $produtor->person->nome)->implode(', ') }}<br>
    </div>

    <hr>

    <div class="mb-4">
        <h4 class="topicos p-2">Elenco</h4>

        @foreach ($filme->actors as $ator)
            @include('partials.div-atores-pagina-detalhes-de-filmes')
        @endforeach
    </div>

    <hr>

    <h3 class="mb-4">Fotos</h3>

    @forelse ($filme->images as $imagem)
        <img style="max-width: 15%" src="{{ asset('storage/' . $imagem->caminho) }}" alt="Imagem de {{ $filme->nome }}"
            class="img-fluid rounded w-10" title="Imagem de {{ $filme->nome }}">
    @empty
        <h5 class="color-warning">Sem imagens</h5>
    @endforelse



    </div>

@endsection
