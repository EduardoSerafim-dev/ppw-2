@extends('layouts.app')

@section('titulo', 'Filme - ' . $filme->nome)

@section('conteudo')

    <style>
        .topicos {
            border-left: solid 10px #a0d6fa;
        }

        .topicos:hover {
            transition-duration: 0.5s;
            border-left: solid 10px #13669c;
        }

        .botao-form {

            background-color: white
        }


        .botao-form:hover {

            background-color: black;
        }

        .avaliacoes {

            box-shadow: none;
        }

        .avaliacoes:hover {

            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
    </style>

    <div class=" mt-4 mb-4 mx-4">

        <div class="clearfix">

            {{-- Exibe o poster se existir, ou uma imagem padrão --}}
            @php
                $poster = $filme->images->firstWhere('pivot.poster', true);
            @endphp

            @if ($poster)
                <img style="max-width: 250px" src="{{ asset('storage/' . $poster->caminho) }}"
                    alt="Poster de {{ $filme->nome }}" class="float-md-start mb-3 mx-md-3 rounded"
                    title="Poster de {{ $filme->nome }}">
            @else
                <img style="max-width: 250px" src="{{ asset('imagens/sem-poster.jpg') }}" alt="Sem poster" title="Sem poster"
                    class="float-md-start mb-3 mx-md-3 rounded">
            @endif

            <p>
            <h3>{{ $filme->nome }}</h3>
            </p>
            <p class="mt-2 "><i class="bi bi-star-fill text-warning"></i>
                {{ number_format($media_notas, 1, ',', '.') }}/10</p>
            <small>
                <strong>Classificação:</strong> {{ $filme->classificacao }} <br>
                <strong>Data de lançamento: </strong>{{ \Carbon\Carbon::parse($filme->data_lancamento)->format('d/m/Y') }}
                <br><br>
            </small>
            <p><strong>Sinopse: </strong> {{ $filme->sinopse }}</p>
            </p>
            <p>
                And yet, here you are, still persevering in reading this placeholder text, hoping for some more insights, or
                some hidden easter egg of content. A joke, perhaps. Unfortunately, there’s none of that here. Lorem ipsum
                dolor
                sit amet consectetur adipisicing elit. Facilis dolorum iste illum aperiam minima. Corporis accusamus aut
                sequi,
                expedita fuga, vitae cupiditate quae magnam quo beatae minus, voluptas iusto nisi. Lorem ipsum dolor sit
                amet
                consectetur adipisicing elit. Quia numquam iure corrupti ullam. Quas, expedita! Placeat, iure, ipsa
                voluptates
                ducimus tenetur necessitatibus repellendus aliquam voluptatum facilis deleniti cumque totam alias. Lorem
                ipsum dolor, sit amet consectetur adipisicing elit. Vitae eveniet repudiandae laudantium, eaque voluptates
                similique, culpa quia atque ea error quas repellat minima corrupti nesciunt doloremque consequatur ut
                inventore in?
            </p>

            <p>
                <strong>Gêneros: </strong>{{ $filme->genres->map(fn($genero) => $genero->nome)->implode(', ') }}
            </p>
        </div>

        <hr>

        <div class="mb-4">
            <h4 class="topicos p-2">Direção, Roteiro e Produção</h4>

            <strong class="p-4">Diretor(es):
            </strong>{{ $filme->directors->map(fn($diretor) => $diretor->person->nome)->implode(', ') }}<br>

            <strong class="p-4">Roteirista(s):
            </strong>{{ $filme->writers->map(fn($escritor) => $escritor->person->nome)->implode(', ') }}<br>

            <strong class="p-4">Produtor(es):
            </strong>{{ $filme->producers->map(fn($produtor) => $produtor->person->nome)->implode(', ') }}<br>
        </div>

        <hr>

        <div class="mb-4">
            <h4 class="topicos p-2">Elenco</h4>

            @foreach ($filme->actors as $ator)
                @include('partials.div-atores-pagina-detalhes-de-filmes')
            @endforeach
        </div>

        <hr>

        <div class="mb-4">
            <h4 class="topicos p-2">Imagens do Filme</h4>

            @foreach ($filme->images as $imagem)
                <a href="/imagens-p/{{ $imagem->id }}">
                    <img style="max-width: 300px" src="{{ asset('storage/' . $imagem->caminho) }}"
                        alt="{{ $imagem->nome }}" class="float mb-3 mx-1 rounded" title="{{ $imagem->nome }}">
                </a>
            @endforeach
        </div>

        <hr>

        <div class="mb-4">
            <h4 class="topicos p-2">Avaliação </h4>

            @auth
                <form action="/avaliacoes/{{ $filme->id }}" method="POST"
                    style="background-color:#a0d6fa; padding: 1rem; border-radius: 10px; max-width: 70%;">
                    @csrf
                    @include('avaliacoes.form')
                    <div class="d-flex justify-content-center" style="border-top: solid 0.5px white; padding-top: 2%">
                        <button type="submit" class="botao-form btn btn-outline-dark">+ Adicionar Avaliação</button>
                    </div>
                </form>
            @endauth
            @guest
                <div style="background-color:#a0d6fa; padding: 1rem; border-radius: 10px; max-width: 70%;">
                    <h5 class="d-flex justify-content-center mb-1 mt-1">
                        Cadastre-se ou faça login para deixar sua avaliação
                        sobre o filme:</h5>
                    <div class="d-flex justify-content-center gap-3" style="padding-top: 2%">
                        <button class="botao-form btn btn-outline-dark">Cadastrar</button>
                        <button class="botao-form btn btn-outline-dark">Fazer Login</button>
                    </div>
                    </form>
                @endguest

            </div>

            <hr>

            {{-- resources/views/filmes/show.blade.php --}}
            <section class="mb-4" id="secao-avaliacoes">
                <h4 class="topicos p-2">Avaliações</h4>
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

            <hr>

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
            <a style="text-decoration: none" href="/avaliacoes-p/${av.id}">
            <div class=" avaliacoes card mb-2 col">
            <div class="card-body">
            <div class="d-flex justify-content-between">
            <strong>${av.user.name}</strong>
            <span class="badge text-bg-warning" style="width: 60px">${av.nota}/10</span>
            </div>
            <p class="mb-0">${av.descricao ? diminuirDescricao(av.descricao) : ''}</p>
            </div>
            </div>
            </a>
            `).join('');
                }


                function diminuirDescricao(descricao) {

                    if (descricao.length > 100) {

                        novaDesc = descricao.slice(0, 100);
                        return novaDesc + '...';
                    }

                    return descricao;
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
