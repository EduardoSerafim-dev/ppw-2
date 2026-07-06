<style>
    .card-filme {

        width: 15%;
        height: 15%;
        transition: 0.3s;
        cursor: pointer;
    }

    .card-filme:hover {

        transform: scale(1.05);
    }


    .filme-img {

        width: 120px;
        height: 120px;
        object-fit: cover;
    }
</style>

<div>
    <div class="d-flex mt-1 p-2 flex-shrink-0 overflow-auto">
        <div class="card-filme text-center">

            <a href="/filmes-p/{{ $filme->id }}">

                @php
                    $imagem_filme = $filme->images->firstWhere('pivot.poster', true);
                @endphp

                @if ($imagem_filme)
                    <img src="{{ asset('storage/' . $imagem_filme->caminho) }}" alt="Filme: {{ $filme->nome }}"
                        class="rounded-circle filme-img" title="{{ $filme->nome }}">
                @else
                    <img src="{{ asset('imagens/sem-poster.jpg') }}" alt="Sem foto do ator" title="Sem foto do ator"
                        class="rounded-circle filme-img">
                @endif

            </a>
        </div>
        <div class="d-flex flex-column">
            <h4>{{ $filme->nome }}</h4>
            <span class="text-muted">Como {{ $filme->pivot->papel }}</span>
        </div>
    </div>
    <hr class="mx-5">
</div>
