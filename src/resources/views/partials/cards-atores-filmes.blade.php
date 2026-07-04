<style>
    .card-ator {

        width: 15%;
        height: 15%;
        transition: 0.3s;
        cursor: pointer;
    }

    .card-ator:hover {

        transform: scale(1.05);
    }


    .ator-img {

        width: 120px;
        height: 120px;
        object-fit: cover;
    }
</style>

<div>
    <div class="d-flex mt-1 p-2 flex-shrink-0 overflow-auto">
        <div class="card-ator text-center">

            <a href="/pessoas/{{ $ator->person->id }}">

                @php
                    $imagem_pessoa = $ator->person->images->first();
                @endphp

                @if ($imagem_pessoa)
                    <img src="{{ asset('storage/' . $imagem_pessoa->caminho) }}" alt="Ator: {{ $ator->person->nome }}"
                        class="rounded-circle ator-img" title="{{ $ator->person->nome }}">
                @else
                    <img src="{{ asset('imagens/sem-poster.jpg') }}" alt="Sem foto do ator" title="Sem foto do ator"
                        class="rounded-circle ator-img">
                @endif

            </a>
        </div>
        <div class="d-flex flex-column">
            <h4>{{ $ator->person->nome }}</h4>
            <span class="text-muted">Como {{ $ator->pivot->papel }}</span>
        </div>
    </div>
    <hr class="mx-5">
</div>
