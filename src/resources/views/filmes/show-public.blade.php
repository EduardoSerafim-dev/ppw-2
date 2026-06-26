@extends('layouts.app')

@section('titulo', 'Criando Filme')

@section('conteudo')

    <style>
        .topicos {
            border-left: solid 10px #a0d6fa;
            border-bottom: solid 1px #000000;
        }

        .topicos:hover {
            transition-duration: 0.5s;
            border-left: solid 10px #13669c;
        }
    </style>

    <div style="margin-top: 5%; margin-bottom: 3%">
        <h1 class="d-flex justify-content-center mt-4 mb-4">{{ $filme->nome }}</h1>
    </div>

    <div class="card mt-4 mb-4 mx-4 shadow-lg">
        <div class="row g-0">
            <div class="col-md-2">
                {{-- Exibe o poster se existir, ou uma imagem padrão --}}
                @php
                    $poster = $filme->images->firstWhere('pivot.poster', true);
                @endphp

                @if ($poster)
                    <img src="{{ asset('storage/' . $poster->caminho) }}" alt="Poster de {{ $filme->nome }}"
                        class="img-fluid rounded w-10" title="Poster de {{ $filme->nome }}">
                @else
                    <img src="{{ asset('imagens/sem-poster.jpg') }}" alt="Sem poster" title="Sem poster"
                        class="img-fluid rounded w-10">
                @endif
            </div>
            <div class="col-md-10">
                <div class="card-body">
                    <p class="card-text"><strong>Sinopse: </strong> {{ $filme->sinopse }}</p>
                    <small>
                        <strong>Duração:</strong> {{ $filme->duracao }} minutos <br>
                        <strong>Classificação:</strong> {{ $filme->classificacao }} <br>
                        <strong>Data de lançamento:</strong>
                        {{ \Carbon\Carbon::parse($filme->data_lancamento)->format('d/m/Y') }} <br>
                        <strong>Gênero(s):</strong>
                        @foreach ($filme->genres as $genero)
                            {{ $genero->nome }}
                        @endforeach
                        <br>
                    </small>
                    <p class="mt-2"><strong>Avaliação:</strong> Estrelas</p>
                </div>
            </div>
        </div>
    </div>

    <h5 class="topicos mb-4 mx-4 p-2">Gêneros</h5>
    <h5 class="topicos mb-4 mx-4 p-2">Direção</h5>
    <h5 class="topicos mb-4 mx-4 p-2">Produção</h5>
    <h5 class="topicos mb-4 mx-4 p-2">Escritores</h5>
    <h5 class="topicos mb-4 mx-4 p-2">Estudio</h5>

    <div style="margin-left: 5%" class="mb-4">

        <h3 class="mb-4">Elenco</h3>

        <h3 class="mb-4">Fotos</h3>

        {{-- resources/views/filmes/show.blade.php --}}
        <section class="mb-4" id="secao-avaliacoes">
            <h3>Avaliações</h3>
            {{-- Container onde o JS injeta os cards de avaliação --}}
            <div class="row gap-2 row-cols-1 row-cols-sm-3 row-cols-md-4 row-cols-lg-5" id="avaliacoes-container">
                <p class="text-muted">Carregando avaliações...</p>
            </div>
            {{-- Navegação AJAX --}}
            <div class="d-flex align-items-center gap-3 mt-3">
                <button id="btn-anterior" class="btn btn-outline-secondary" disabled>
                    ← Anterior
                </button>
                <span id="info-pagina" class="text-muted"></span>
                <button id="btn-proxima" class="btn btn-outline-secondary">
                    Próxima →
                </button>
            </div>
        </section>
        {{-- Script inline com o ID do filme para o JS usar --}}
        {{-- O @push('scripts') com o fetch fica abaixo ou num arquivo separado --}}

    </div>

    @push('scripts')
        <script>
            const filmeId = {{ $filme->id }};
            let paginaAtual = 1;

            function carregarAvaliacoes(pagina) {

                fetch(`/filmes/${filmeId}/avaliacoes?page=${pagina}`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Erro na requisição');
                        return res.json();
                    })
                    .then(dados => {
                        renderizarAvaliacoes(dados.data);
                        atualizarNavegacao(dados);
                        paginaAtual = dados.current_page;
                    })
                    .catch(erro => {
                        console.log(erro);
                        document.getElementById('avaliacoes-container').innerHTML =
                            '<p class="text-danger">Erro ao carregar avaliações.</p>';
                    });
            }

            function renderizarAvaliacoes(avaliacoes) {
                const container = document.getElementById('avaliacoes-container');
                container.innerHTML = avaliacoes.map(av => `
            <a  style="text-decoration: none" href="/avaliacoes/${av.id}">
            <div class="card mb-2 col">
            <div class="card-body">
            <div class="d-flex justify-content-between">
            <strong>${av.user.name}</strong>
            <span class="badge text-bg-warning" style="width: 60px">${av.nota}/10</span>
            </div>
            <p class="mb-0">${av.descricao ?? ''}</p>
            </div>
            </div>
            </a>
            `).join('');
            }

            function atualizarNavegacao(dados) {
                document.getElementById('btn-anterior').disabled = !dados.prev_page_url;
                document.getElementById('btn-proxima').disabled = !dados.next_page_url;
                document.getElementById('info-pagina').textContent =
                    `Página ${dados.current_page} de ${dados.last_page}`;
            }
            document.getElementById('btn-anterior')
                .addEventListener('click', () => carregarAvaliacoes(paginaAtual - 1));
            document.getElementById('btn-proxima')
                .addEventListener('click', () => carregarAvaliacoes(paginaAtual + 1));

            // Carrega a primeira página ao abrir a página
            carregarAvaliacoes(1);
        </script>
    @endpush

@endsection
