@extends('layouts.app')

@section('titulo', 'Lista de Filmes')

@section('conteudo')

    <div style=" margin: 5% 0 5% 0">
        <h1 class='mb-4 mt-4 d-flex justify-content-center'>Filmes</h1>

        {{-- Formulário de busca com GET --}}
        <form action="/filmes" method="GET" class="mb-4 mt-4">
            <div class="row g-2 justify-content-center">
                <div class="col-md-5">
                    <input type="text" name="busca" value="{{ request('busca') }}" class="form-control"
                        placeholder="Buscar filmes...">
                </div>
                <div class="col-md-2">
                    <select name="genero" class="form-select">
                        <option value="">Todos os gêneros</option>
                        @foreach ($generos as $g)
                            <option value="{{ $g->id }}" {{ request('genero') == $g->id ? 'selected' : '' }}>
                                {{ $g->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="ordem" class="form-select">
                        <option value="nome" {{ request('ordem') === 'nome' ? 'selected' : '' }}>
                            A–Z</option>
                        <option value="ano" {{ request('ordem') === 'ano' ? 'selected' : '' }}>
                            Mais recentes</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-dark  w-100">Buscar</button>
                </div>
            </div>
        </form>
    </div>


    <div class="d-flex justify-content-end">
        <a href="/filmes/create" class="btn btn-success mx-4">
            + Criar Novo Filme
        </a>
    </div>

    @forelse ($filmes as $filme)
        <div class="card mt-4 mb-4 mx-4 shadow-lg">
            <div class='row g-3'>
                <div class="col-md-2">
                    {{-- Exibe o poster se existir, ou uma imagem padrão --}}
                    @php
                        $poster = $filme->images->firstWhere('pivot.poster', true);
                    @endphp

                    @if ($poster)
                        <img src="{{ asset('storage/' . $poster->caminho) }}" alt="Poster de {{ $filme->nome }}"
                            class="img-fluid rounded" style="width: 240px;" title="Poster de {{ $filme->nome }}">
                    @else
                        <img src="{{ asset('imagens/sem-poster.jpg') }}" alt="Sem poster" title="Sem poster"
                            class="img-fluid rounded w-10" style="width: 148px;">
                    @endif
                </div>
                <div class="col-md-10">
                    <div class="card-body">
                        <p class="card-text">
                        <h3>{{ $filme->nome }}</h3>
                        <div class="d-flex justify-content-between">
                            <p><strong>Duração:</strong> {{ $filme->duracao }} minutos</p>
                            <p><strong>Classificação:</strong> {{ $filme->classificacao }}</p>
                            <p><strong>Data de lançamento:</strong>
                                {{ \Carbon\Carbon::parse($filme->data_lancamento)->format('d/m/Y') }}</p>
                        </div>

                        <div class="d-flex gap-3">

                            <a href="/filmes/{{ $filme->id }}" class="btn btn-dark">
                                <i class="bi bi-info-circle"></i> Visualizar este filme
                            </a>

                            {{-- <a href="/avaliacoes/create/{{ $filme->id }}" class="btn btn-primary">
                                <i class="bi bi-star"></i> Avaliar
                            </a> --}}

                            <a href="/filmes/{{ $filme->id }}/edit" class="btn btn-warning">
                                Editar
                            </a>

                            {{-- Botão de remoção do filme --}}
                            <form action="/filmes/{{ $filme->id }}" method="POST"
                                onsubmit="return confirm('Remover este filme?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    Remover
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class='col-12'>
            {{-- Mensagem quando não há resultados --}}
            <div class='alert alert-warning'>
                Nenhum filme encontrado
                @if (request('busca'))
                    para "{{ request('busca') }}".
                @else
                    com os filtros selecionados.
                @endif
                <br>
                <a href="/filmes"> >Ver todos os filmes</a>
            </div>
        </div>
    @endforelse
    </div>

    {{-- Feedback de busca --}}
    @if (request('busca') || request('genero'))
        <div class="d-flex justify-content-between align-items-center mb-3 mx-4">
            <p class="mb-0 text-muted">
                {{ $filmes->total() }} resultado(s)
                @if (request('busca'))
                    para "<strong>{{ request('busca') }}</strong>"
                @endif
            </p>
            {{-- Link para limpar todos os filtros --}}
            <a href="/filmes" class="btn btn-sm btn-outline-dark">
                Limpar filtros
            </a>
        </div>
    @endif

    {{-- Renderiza os botões de paginação --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $filmes->links('pagination.custom') }}
    </div>

    @auth
        @if (auth()->user()->isAdmin())
            {{-- Informações sobre a página atual --}}
            <p class="text-muted text-center">
                Exibindo {{ $filmes->firstItem() }}–{{ $filmes->lastItem() }}
                de {{ $filmes->total() }} filmes
            </p>
        @endif
    @endauth

@endsection
