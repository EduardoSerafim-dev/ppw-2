@if ($avaliacoesMaisRecentes->isNotEmpty())

    <div id="carouselAvaliacoes" class="carousel slide mb-5" data-bs-ride="carousel">

        <div class="carousel-inner">

            @foreach ($avaliacoesMaisRecentes->chunk(3) as $grupo)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">

                    <div class="row px-5">

                        @foreach ($grupo as $avaliacao)
                            <div class="col-md-4">

                                <a href="/avaliacoes-p/{{ $avaliacao->id }}" class="text-decoration-none text-dark">

                                    <div class="card shadow-sm h-100 avaliacao-card">

                                        <div class="card-body">

                                            <div class="d-flex justify-content-between">

                                                <strong>
                                                    Autor:
                                                    {{ $avaliacao->user->name }}
                                                </strong>

                                                <span class="badge text-bg-warning">
                                                    {{ $avaliacao->nota }}/10
                                                </span>

                                            </div>

                                            <small class="text-muted">
                                                <strong>Sobre:</strong>
                                                {{ $avaliacao->movie->nome }}
                                            </small>

                                            <p class="mt-2 mb-0">
                                                {{ \Illuminate\Support\Str::limit($avaliacao->descricao, 120) }}
                                            </p>

                                        </div>

                                    </div>

                                </a>

                            </div>
                        @endforeach

                    </div>

                </div>
            @endforeach

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselAvaliacoes" data-bs-slide="prev">

            <span class="carousel-control-prev-icon"></span>

        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselAvaliacoes" data-bs-slide="next">

            <span class="carousel-control-next-icon"></span>

        </button>

    </div>

@endif
