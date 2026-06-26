<div class="form-group mb-2">
    <label for="nome">
        <h6>Título do Filme</h6>

    </label>
    <input type="text" name="nome" id="nome" value="{{ old('nome', $filme->nome ?? '') }}"
        class="form-control @error('nome') is-invalid @enderror" placeholder="Digite o título do filme...">
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="duracao">
        <h6>Duração</h6>
    </label>
    <input type="number" name="duracao" id="duracao" value="{{ old('duracao', $filme->duracao ?? '') }}"
        class="form-control @error('duracao') is-invalid @enderror"
        placeholder="Digite a duração do filme em minutos...">
    @error('duracao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="data_lancamento">
        <h6>Data de Lançamento</h6>
    </label>
    <input type="date" name="data_lancamento" id="data_lancamento"
        value="{{ old('data_lancamento', $filme->data_lancamento ?? '') }}"
        class="form-control @error('data_lancamento') is-invalid @enderror"
        placeholder="Selecione a data de lançamento do filme...">
    @error('data_lancamento')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="classificacao">
        <h6>Classificação</h6>
    </label>
    <input type="text" name="classificacao" id="classificacao"
        value="{{ old('classificacao', $filme->classificacao ?? '') }}"
        class="form-control @error('classificacao') is-invalid @enderror"
        placeholder="Digite a Classificação Indicativa do filme...">
    @error('classificacao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="sinopse">
        <h6>Sinopse</h6>

    </label>
    <textarea name="sinopse" id="sinopse" rows="5" cols="30"
        class="form-control @error('sinopse') is-invalid @enderror" placeholder="Escreva a sinopse do filme...">
{{-- old() para textarea fica entre as tags, não no value --}}
        {{ old('sinopse', $filme->sinopse ?? '') }}
    </textarea>
    @error('sinopse')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="genero">
        <h6>Gênero(s)</h6>
    </label>
    @foreach ($generos as $genero)
        <div class="form-check form-switch">
            <input class="form-check-input" name="generos[]" type="checkbox" value="{{ $genero->id }}" role="switch"
                id="genero{{ $genero->id }}"
                @isset($filme)                    
                {{ in_array($genero->id, old('generos', $filme->genres->pluck('id')->toArray())) ? 'checked' : '' }}>
                @endisset
                <label class="form-check-label" for="genero{{ $genero->id }}">
            {{ $genero->nome }}
            </label>
        </div>
    @endforeach
</div>

{{-- Na partial form-filme.blade.php --}}
@if (isset($filme))
    <div class="mb-3">
        <label class="form-label fw-bold">Pessoas vinculadas</label>
        @foreach ([
        'actors' => ['label' => 'Ator', 'temPersonagem' => true],
        'directors' => ['label' => 'Diretor', 'temPersonagem' => false],
        'producers' => ['label' => 'Produtor', 'temPersonagem' => false],
        'writers' => ['label' => 'Escritor', 'temPersonagem' => false],
    ] as $relacao => $config)
            @foreach ($filme->$relacao as $item)
                <div class="d-flex align-items-center gap-2 mb-2 card-vinculo-existente">
                    <span class="badge bg-secondary">{{ $config['label'] }}</span>
                    <span>{{ $item->person->nome }}</span>
                    @if ($config['temPersonagem'])
                        <input type="text" name="atores_existentes[{{ $item->id }}][personagem]"
                            value="{{ $item->pivot->papel }}" class="form-control form-control-sm" style="width:180px"
                            placeholder="Personagem">
                    @endif
                    {{-- Marcador para remoção --}}
                    <input type="checkbox" name="remover_vinculos[{{ $relacao }}][]" value="{{ $item->id }}"
                        class="form-check-input" title="Remover">
                    <label class="form-check-label text-danger small">Remover</label>
                </div>
            @endforeach
        @endforeach
    </div>
@endif

{{-- Seção de vínculos na partial form-filme.blade.php --}}
<div class="mb-4">
    <label class="form-label fw-bold">Pessoas vinculadas</label>
    {{-- Container onde os cards de vínculo são inseridos --}}
    <div id="vinculos-container"></div>
    <button type="button" id="btn-vincular" class="btn btn-outline-dark btn-sm mt-2">
        + Vincular pessoa
    </button>
</div>

{{-- Template de um card de vínculo (oculto, clonado pelo JS) --}}
<template id="template-vinculo">
    <div class="card mb-2 card-vinculo">
        <div class="card-body p-2">
            {{-- Campo de busca visível + campo oculto com o ID --}}
            <input type="text" class="form-control mb-2 campo-busca" placeholder="Buscar pelo nome da pessoa...">
            <div class="lista-resultados list-group mb-2"></div>
            <input type="hidden" name="" class="campo-pessoa-id">
            <b><span class="nome-pessoa small strong"></span></b>
            <select name="" class="form-select form-select-sm mb-2 campo-tipo" required id="campo-tipo">
                <option value="" disabled selected hidden>Trabalhou como...</option>
            </select>
            <input type="text" name="" class="form-control form-control-sm campo-personagem"
                placeholder="Nome do personagem">
            <button type="button" class="btn btn-sm btn-outline-danger mt-1 btn-remover">
                Remover vínculo
            </button>
        </div>
    </div>
</template>

<div class="mb-1">
    <label class="form-label fw-bold">
        {{ isset($filme) ? 'Adicionar novas imagens' : 'Imagens' }}
    </label>
    {{-- ... campos dinâmicos de upload (como antes) ... --}}
    {{-- Container que recebe os novos campos --}}
    <div id="campos-imagem">
        <div class="campo-imagem mb-2 d-flex align-items-center gap-2">
            <input type="file" name="imagens[]" class="form-control" accept="image/jpeg,image/png,image/webp">
            <label class="mb-0">
                <input type="checkbox" name="poster_index" value="0"> Poster
            </label>
        </div>
    </div>
    {{-- Erro no array em si (ex.: 'Envie ao menos uma imagem.') --}}
    @error('imagens')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    {{-- Erros individuais por índice --}}
    @foreach ($errors->get('imagens.*') as $erros)
        @foreach ($erros as $erro)
            <div class="text-danger small">{{ $erro }}</div>
        @endforeach
    @endforeach
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $erro)
                <div>{{ $erro }}</div>
            @endforeach
        </div>
    @endif
    <button type="button" id="btn-adicionar" class="btn btn-outline-dark btn-sm">
        + Adicionar imagem
    </button>
</div>

{{-- Bloco de imagens existentes — só aparece na edição --}}
@if (isset($filme) && $filme->images->isNotEmpty())
    <div class="mb-1">
        <label class="form-label fw-bold">Imagens cadastradas</label>
        <div class="d-flex flex-wrap gap-3">
            @foreach ($filme->images as $imagem)
                <div class="text-center" style="width: 130px">
                    <img src="{{ asset('storage/' . $imagem->caminho) }}" class="img-thumbnail mb-1"
                        style="height: 90px; object-fit: cover">
                    {{-- Radio para definir como poster --}}
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="poster_imagem_id"
                            value="{{ $imagem->id }}" {{ $imagem->pivot->poster ? 'checked' : '' }}>
                        <label class="form-check-label small">Poster</label>
                    </div>
                    {{-- Botão de remoção individual --}}
                    <button type="button" class="btn btn-outline-danger btn-sm w-100 btn-remover-imagem"
                        data-imagem="{{ $imagem->id }}">
                        Remover
                    </button>
                </div>
            @endforeach
        </div>
    </div>
@endif

@push('scripts')
    <script>
        // JS dos campos de upload de imagens =========================================

        const container_imagens = document.getElementById('campos-imagem');
        const btnAdicionar = document.getElementById('btn-adicionar');
        let indice_imagens = 1;
        const MAX_FOTOS = 5;
        btnAdicionar.addEventListener('click', () => {
            if (indice_imagens >= MAX_FOTOS) {
                alert('Máximo de ' + MAX_FOTOS + ' imagens.');
                return;
            }
            const div = document.createElement('div');
            div.className = 'campo-imagem mb-2 d-flex align-items-center gap-2';
            div.innerHTML = `
                        <input type="file" name="imagens[]" class="form-control"
                        accept="image/jpeg,image/png,image/webp">
                        <label class="mb-0">
                        <input type="checkbox" name="poster_index" value="${indice}"> Poster
                        </label>
                        <button type="button" class="btn btn-sm btn-outline-danger"
                        onclick="this.closest('.campo-imagem').remove()">✕</button>`;
            container_imagens.appendChild(div);
            indice_imagens++;
        });

        // JS dos botões de remoção de imagens =========================================

        document.querySelectorAll('.btn-remover-imagem').forEach(btn => {

            btn.addEventListener('click', () => {

                if (!confirm('Remover esta imagem?')) {
                    return;
                }

                const imagemId = btn.dataset.imagem;
                const filmeId = {{ $filme->id }};

                const form = document.getElementById('form-remover-imagem');

                form.action = `/imagens/${imagemId}/filme/${filmeId}`;

                form.submit();
            });

        });

        // JS dos vínculos de pessoas ===================================================

        const filmeId = {{ $filme->id ?? 'null' }};
        const container = document.getElementById('vinculos-container');
        const template = document.getElementById('template-vinculo');
        const csrfToken = document.querySelector('input[name="_token"]').content;
        let indice = 0;
        document.getElementById('btn-vincular').addEventListener('click', () => {
            const card = template.content.cloneNode(true).querySelector('.card-vinculo');
            // Nomeia os campos com o índice atual
            card.querySelector('.campo-pessoa-id').name = `vinculos[${indice}][pessoa_id]`;
            card.querySelector('.campo-tipo').name = `vinculos[${indice}][tipo]`;
            card.querySelector('.campo-personagem').name = `vinculos[${indice}][personagem]`;
            inicializarCard(card);
            container.appendChild(card);
            indice++;
        });

        function inicializarCard(card) {
            const campoBusca = card.querySelector('.campo-busca');
            const listaResultados = card.querySelector('.lista-resultados');
            let timer;
            // Debounce: aguarda 300ms após o usuário parar de digitar
            campoBusca.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(() => buscarPessoas(campoBusca.value, listaResultados, card), 300);
            });
            // Exibir/ocultar campo de personagem conforme o tipo
            card.querySelector('.campo-tipo').addEventListener('change', (e) => {
                card.querySelector('.campo-personagem').style.display =
                    e.target.value === 'ator' ? 'block' : 'none';
            });
            // Remover card
            card.querySelector('.btn-remover').addEventListener('click', () => {
                card.remove();
                reindexarVinculos();
            });
        }

        function buscarPessoas(termo, lista, card) {
            if (termo.length < 2) {
                lista.innerHTML = '';
                return;
            }
            fetch(`/pessoas/buscar?q=${encodeURIComponent(termo)}&filme_id=${filmeId ?? ''}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(pessoas => {
                    lista.innerHTML = '';
                    if (pessoas.length === 0) {
                        lista.innerHTML = '<span class="list-group-item text-muted">Nenhum resultado</span>';
                        return;
                    }
                    pessoas.forEach(p => {
                        const item = document.createElement('button');
                        item.type = 'button';
                        item.className = 'list-group-item list-group-item-action';
                        // Avisa se já existe vínculo deste tipo
                        const aviso = p.vinculos.length > 0 ?
                            ` <small class="text-warning">(já vinculado como ${p.vinculos.join(', ')})</small>` :
                            '';
                        item.innerHTML = `${p.nome}${aviso}`;
                        item.addEventListener('click', () => {
                            // Preenche os campos ocultos e exibe o nome selecionado
                            card.querySelector('.campo-pessoa-id').value = p.id;
                            card.querySelector('.campo-busca').value = '';
                            card.querySelector('.nome-pessoa').textContent = ' ' + p.nome;
                            lista.innerHTML = ''; // fecha a lista

                            // Exibe as opções de profissões disponíveis de acordo com determinada pessoa
                            const select = card.querySelector('.campo-tipo');

                            p.profissoes.forEach(profissao => {
                                select.innerHTML +=
                                    `<option value="${profissao.toLowerCase()}">${profissao}</option>`;
                            });

                        });
                        lista.appendChild(item);
                    });
                })
                .catch(err => console.log(err));
        }

        function reindexarVinculos() {
            container.querySelectorAll('.card-vinculo').forEach((card, i) => {
                card.querySelector('.campo-pessoa-id').name = `vinculos[${i}][pessoa_id]`;
                card.querySelector('.campo-tipo').name = `vinculos[${i}][tipo]`;
                card.querySelector('.campo-personagem').name = `vinculos[${i}][personagem]`;
            });
            indice = container.querySelectorAll('.card-vinculo').length;
        }
    </script>
@endpush
