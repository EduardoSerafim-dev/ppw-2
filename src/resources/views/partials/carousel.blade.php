{{-- <div class="d-flex justify-content-center">
    <div style="width: 60%; height: 60%;" id="carouselExampleAutoplaying" class="carousel slide mb-4 shadow-lg rounded"
        data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('imagens/odisseia-de-christopher-nolan.webp') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Odisseia</h3>
                    <p>Novo filme de Christopher Nolan</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('imagens/spider-man_brand_new_day.webp') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Homem-Aranha: Um Novo Dia</h3>
                    <p>Uma nova aventura do amigão da vizinhança</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('imagens/O-Mandaloriano-e-Grogu-Filme-Star-Wars.jpg') }}" class="d-block w-100"
                    alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h3>O Mandaloriano e Grogu</h3>
                    <p>Do universo de Star Wars</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

@foreach ($filmesMaisRecentes as $filme)
    <div class="carousel-item">
        @php
            $imagem = $filme->images->first();
        @endphp
        @if ($imagem)
            <img src="{{ asset('storage/' . $imagem->caminho) }}" alt="{{ $imagem->nome }}" class="d-block w-100"
                title="{{ $imagem->nome }}">
            <div class="carousel-caption d-none d-md-block">
                <h3>{{ $filme->nome }}</h3>
                <p>diminuirDescricao</p>
            </div>
        @else
            <img src="{{ asset('imagens/sem-poster.jpg') }}" alt="Sem poster" title="Sem poster" class="d-block w-100"
                alt="...">
        @endif
@endforeach --}}

<div class="d-flex justify-content-center mb-5">
    <div style="width: 60%;" id="carouselExampleAutoplaying" class="carousel slide mb-4 shadow-lg rounded"
        data-bs-ride="carousel">

        <div class="carousel-inner">

            @foreach ($filmesMaisRecentes as $filme)
                @php
                    $imagem = $filme->images->first();
                @endphp

                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">

                    <a href="/filmes-p/{{ $filme->id }}">

                        @if ($imagem)
                            <img src="{{ asset('storage/' . $imagem->caminho) }}" alt="{{ $filme->nome }}"
                                title="{{ $imagem->nome }}" class="d-block w-100"
                                style="height: 500px; object-fit: cover;">
                        @else
                            <img src="{{ asset('imagens/sem-poster.jpg') }}" alt="Sem poster" title="Sem poster"
                                class="d-block w-100" style="height: 500px; object-fit: cover;">
                        @endif

                        <div class="carousel-caption d-none d-md-block">
                            <h3>{{ $filme->nome }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit($filme->descricao, 180) }}</p>
                        </div>

                    </a>

                </div>
            @endforeach

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="prev">

            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>

        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="next">

            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>

        </button>

    </div>
</div>
