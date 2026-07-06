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
            <div class="d-flex justify-content-center align-items-center">
                <div class="mx-4">Pesquisando por: <br> <b>"{{ request('busca') }}"</b>
                </div>
            </div>
        </h4>

        <div class="mx-4">
            <h5 class="mb-0">{{ $pessoas->count() + $filmes->count() }} resultado(s) encontrado(s)</h5>
            <hr>
        </div>


        {{-- PESSOAS --}}
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mx-4">
                <h3>Pessoas</h3>
                <h5 class="mb-0">{{ $pessoas->count() }} resultado(s)</h5>
            </div>


            {{-- <div class="row row-cols-1 row-cols-md-4 mx-4 mt-4 g-1 "> --}}
            @forelse($pessoas as $pessoa)
                @include('partials.div-de-pessoas-pagina-de-busca')
            @empty
                <p>Nenhuma pessoa encontrada.</p>
            @endforelse
        </div>

        <hr>
        {{-- FILMES --}}
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mx-4">
                <h3>Filmes</h3>
                <h5 class="mb-0">{{ $filmes->count() }} resultado(s)</h5>
            </div>


            @forelse($filmes as $filme)
                @include('partials.div-de-filmes-pagina-de-busca')
            @empty
                <p>Nenhum filme encontrado.</p>
            @endforelse
        </div>

        </div>

        <hr>
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

    <div class="container mb-5">
        <div class="row g-4">
            @foreach ($filmesMaisAvaliados as $filme)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    @include('partials.cards-filmes-home')
                </div>
            @endforeach

        </div>
    </div>


    <div class="container mb-5">
        <div class="row g-4">
            @foreach ($atoresMaisPresentes as $ator)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    @include('partials.cards-atores-home')
                </div>
            @endforeach
        </div>
    </div>

    @include('partials.carousel-cards-avaliacoes-home')


    @endif



@endsection

@push('scripts')
@endpush
