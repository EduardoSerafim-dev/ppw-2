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

    <hr class="mx-4">

    <h5 class="topicos mb-4 mx-4 p-2">Direção</h5>
    <h5 class="topicos mb-4 mx-4 p-2">Produção</h5>
    <h5 class="topicos mb-4 mx-4 p-2">Escritores</h5>
    <h5 class="topicos mb-4 mx-4 p-2">Estudio</h5>

    <div style="margin-left: 5%" class="mb-4">

        <h3 class="mb-4">Elenco</h3>

        <h3 class="mb-4">Fotos</h3>

        @forelse ($filme->images as $imagem)
            <img style="max-width: 15%" src="{{ asset('storage/' . $imagem->caminho) }}"
                alt="Imagem de {{ $filme->nome }}" class="img-fluid rounded w-10" title="Imagem de {{ $filme->nome }}">
        @empty
            <h5 class="color-warning">Sem imagens</h5>
        @endforelse

        <h3 class="mb-4">Avaliações</h3>

        <div class="row gap-2 row-cols-1 row-cols-sm-3 row-cols-md-4 row-cols-lg-5">
            @foreach ($avaliacoes as $av)
                <div class="card mb-2 col">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $av->user->name }}</strong>
                            <span class="badge text-bg-warning" style="width: 60px">{{ $av->nota }}/10</span>
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
        </div>

    </div>

@endsection
