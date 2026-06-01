@extends('layouts.app')

@section('titulo', 'Página inicial')

@section('conteudo')

    <div style="text-align: center; border; margin: 5%;" class="shadow rounded p-3">

        <h1 class="mt-4">CineReview</h1>
        <h5 class="mt-3 mb-4 p-2">
            Bem vindo, procure por filmes, atores, diretores, produtores, estúdios e faça sua avalição!</h5>
    </div>

    @if (request('busca'))

        <h4 class="mb-4">
            Resultados para "{{ request('busca') }}"
        </h4>

        {{-- FILMES --}}
        <div class="mb-5">

            <h3>Filmes</h3>

            @forelse($filmes as $filme)
                <div class="card mb-3">

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

            <h3>Pessoas</h3>

            @forelse($pessoas as $pessoa)
                <div class="card mb-3">

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

        {{-- GÊNEROS --}}
        <div class="mb-5">

            <h3>Gêneros</h3>

            @forelse($generos as $genero)
                <div class="card mb-3">

                    <div class="card-body">

                        <h5>
                            {{ $genero->nome }}
                        </h5>

                    </div>

                </div>

            @empty

                <p>Nenhum gênero encontrado.</p>
            @endforelse

        </div>
    @else
        @include('partials.carousel')
        @include('partials.cards-atores')
        @include('partials.cards-filmes')

    @endif



@endsection
