@extends('layouts.app')

@section('titulo', 'Página inicial')

@section('conteudo')

    <div style="text-align: center; border; margin: 5%;" class="shadow rounded p-3">

        <h1 class="mt-4">CineReview</h1>
        <h5 class="mt-3 mb-4 p-2">
            Bem vindo, procure por filmes, atores, diretores, produtores, estúdios e faça sua avalição!</h5>
    </div>

    @if (request('busca'))

        <h4 style="margin: 0 2% 0 2%; border-bottom: 5px solid #a0d6fa; padding-bottom: 10px" class="mb-4">
            <div class="mx-4">Resultados para <b>"{{ request('busca') }}"</b>:</div>
        </h4>

        {{-- FILMES --}}
        <div class="mb-5">
            <h3 class="mx-4">Filmes</h3>

            @forelse($filmes as $filme)
                <div class="card mb-3 mx-4">
                    <div class="card-body">
                        <h5>
                            <a href="/filmes/{{ $filme->id }}">
                                {{ $filme->nome }}
                            </a>
                        </h5>
                        <p>
                            @foreach ($filme->genres as $genero)
                                <span class="badge bg-secondary">
                                    {{ $genero->nome }}
                                </span>
                            @endforeach
                        </p>
                    </div>
                </div>
            @empty
                <p>Nenhum filme encontrado.</p>
            @endforelse
        </div>

        {{-- PESSOAS --}}
        <div class="mb-5">
            <h3 class="mx-4">Pessoas</h3>

            <div class="row row-cols-1 row-cols-md-4 mx-4 mt-4 g-1 ">
                @forelse($pessoas as $pessoa)
                    <div class="card mb-1">
                        <div class="card-body">
                            <h5>
                                <a href="/pessoas/{{ $pessoa->id }}">
                                    {{ $pessoa->nome }}
                                </a>
                            </h5>
                            <p>
                                @if ($pessoa->actor)
                                    <span class="badge bg-primary">
                                        Ator
                                    </span>
                                @endif
                                @if ($pessoa->director)
                                    <span class="badge bg-success">
                                        Diretor
                                    </span>
                                @endif
                                @if ($pessoa->writer)
                                    <span class="badge bg-warning text-dark">
                                        Escritor
                                    </span>
                                @endif
                                @if ($pessoa->producer)
                                    <span class="badge bg-danger">
                                        Produtor
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                @empty
                    <p>Nenhuma pessoa encontrada.</p>
                @endforelse
            </div>

        </div>

        {{-- GÊNEROS --}}
        <div class="mb-5">
            <h3 class="mx-4">Gêneros</h3>
            <div class="row row-cols-1 row-cols-md-4 mx-4 mt-4 g-1 ">
                @forelse($generos as $genero)
                    <div>
                        <div class="card mb-1">
                            <div class="card-body">
                                <h5>
                                    {{ $genero->nome }}
                                </h5>
                            </div>
                        </div>
                    </div>
                @empty
            </div>
            <p>Nenhum gênero encontrado.</p>
    @endforelse
    </div>
@else
    @include('partials.carousel')
    @include('partials.cards-atores')
    @include('partials.cards-filmes')

    @endif



@endsection
