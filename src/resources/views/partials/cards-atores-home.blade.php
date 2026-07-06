{{-- <style>
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
    <div class="d-flex gap-5 mt-5 mb-5 p-2 flex-shrink-0 overflow-auto">

        <div class="card-ator text-center">

            <img src="{{ asset('imagens/ator1.webp') }}" class="rounded-circle ator-img" alt="Robert Downey Jr.">
            <h6 class="mt-2">Robert Downey Jr.</h6>

        </div>

        <div class="card-ator text-center">

            <img src="{{ asset('imagens/ator1.webp') }}" class="rounded-circle ator-img" alt="Robert Downey Jr.">
            <h6 class="mt-2">Robert Downey Jr.</h6>

        </div>

        <div class="card-ator text-center">

            <img src="{{ asset('imagens/ator2.webp') }}" class="rounded-circle ator-img" alt="Christian Bale">
            <h6 class="mt-2">Christian Bale</h6>

        </div>

        <div class="card-ator text-center">

            <img src="{{ asset('imagens/ator3.webp') }}" class="rounded-circle ator-img" alt="J.K. Simmons">
            <h6 class="mt-2">J.K. Simmons</h6>

        </div>
        <div class="card-ator text-center">

            <img src="{{ asset('imagens/ator3.webp') }}" class="rounded-circle ator-img" alt="J.K. Simmons">
            <h6 class="mt-2">J.K. Simmons</h6>

        </div>
        <div class="card-ator text-center">

            <img src="{{ asset('imagens/ator3.webp') }}" class="rounded-circle ator-img" alt="J.K. Simmons">
            <h6 class="mt-2">J.K. Simmons</h6>

        </div>
        <div class="card-ator text-center">

            <img src="{{ asset('imagens/ator3.webp') }}" class="rounded-circle ator-img" alt="J.K. Simmons">
            <h6 class="mt-2">J.K. Simmons</h6>

        </div>
        <div class="card-ator text-center">

            <img src="{{ asset('imagens/ator3.webp') }}" class="rounded-circle ator-img" alt="J.K. Simmons">
            <h6 class="mt-2">J.K. Simmons</h6>

        </div>
        <div class="card-ator text-center">

            <img src="{{ asset('imagens/ator3.webp') }}" class="rounded-circle ator-img" alt="J.K. Simmons">
            <h6 class="mt-2">J.K. Simmons</h6>

        </div>
        <div class="card-ator text-center">

            <img src="{{ asset('imagens/ator3.webp') }}" class="rounded-circle ator-img" alt="J.K. Simmons">
            <h6 class="mt-2">J.K. Simmons</h6>

        </div>
        <div class="card-ator text-center">

            <img src="{{ asset('imagens/ator3.webp') }}" class="rounded-circle ator-img" alt="J.K. Simmons">
            <h6 class="mt-2">J.K. Simmons</h6>

        </div>
    </div>
</div> --}}


<div class="card h-100 shadow-sm">

    @php
        $imagem = $ator->person->images->firstWhere('pivot.principal', true);
    @endphp

    @if ($imagem)
        <img src="{{ asset('storage/' . $imagem->caminho) }}" class="card-img-top" alt="{{ $ator->person->nome }}"
            title="{{ $ator->person->nome }}" style="height: 350px; object-fit: cover;">
    @else
        <img src="{{ asset('imagens/sem-poster.jpg') }}" class="card-img-top" alt="Sem foto" title="Sem foto"
            style="height: 350px; object-fit: cover;">
    @endif

    <div class="card-body d-flex flex-column">

        <h5 class="card-title">
            {{ $ator->person->nome }}
        </h5>

        <p class="card-text">
            {{ \Illuminate\Support\Str::limit($ator->person->biografia, 120) }}
        </p>

        <a href="/pessoas-p/{{ $ator->person->id }}" class="btn btn-outline-dark mt-auto">
            Ver perfil
        </a>

    </div>

</div>
