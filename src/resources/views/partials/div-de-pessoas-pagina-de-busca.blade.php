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

@php
    $profissoes = [];

    if ($pessoa->actor) {
        $profissoes[] = 'Ator';
    }
    if ($pessoa->director) {
        $profissoes[] = 'Diretor';
    }
    if ($pessoa->producer) {
        $profissoes[] = 'Produtor';
    }
    if ($pessoa->writer) {
        $profissoes[] = 'Escritor';
    }
@endphp

<div>
    <div class="d-flex mt-1 p-2 flex-shrink-0 overflow-auto">
        <div class="card-ator text-center">

            <a href="/pessoas-p/{{ $pessoa->id }}">

                @php
                    $imagem_pessoa = $pessoa->images->firstWhere('pivot.principal', true);
                @endphp

                @if ($imagem_pessoa)
                    <img src="{{ asset('storage/' . $imagem_pessoa->caminho) }}" alt="Ator: {{ $pessoa->nome }}"
                        class="rounded-circle ator-img" title="{{ $pessoa->nome }}">
                @else
                    <img src="{{ asset('imagens/sem-poster.jpg') }}" alt="Sem foto desta pessoa"
                        title="Sem foto desta pessoa" class="rounded-circle ator-img">
                @endif

            </a>
        </div>
        <div class="d-flex flex-column">
            <h4>{{ $pessoa->nome }}</h4>
            <span class="text-muted">{{ implode(', ', $profissoes) }}
            </span>
        </div>
    </div>
    <hr class="mx-5">
</div>
