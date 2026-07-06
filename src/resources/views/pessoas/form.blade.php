<div class="form-group mb-2">
    <label for="nome">
        <h6>Nome</h6>
    </label>
    <input type="text" name="nome" id="nome" value="{{ old('nome', $pessoa->nome ?? '') }}"
        class="form-control @error('nome') is-invalid @enderror" placeholder="Digite o nome da pessoa...">
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mb-2">
    <label for="cpf">
        <h6>CPF</h6>
    </label>
    <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $pessoa->cpf ?? '') }}"
        class="form-control @error('cpf') is-invalid @enderror" placeholder="Digite o cpf...">
    @error('cpf')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="data_nascimento">
        <h6>Data de Nascimento</h6>
    </label>
    <input type="date" name="data_nascimento" id="data_nascimento"
        value="{{ old('data_nascimento', $pessoa->data_nascimento ?? '') }}"
        class="form-control @error('data_nascimento') is-invalid @enderror"
        placeholder="Selecione a data de nascimento...">
    @error('data_nascimento')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="biografia">
        <h6>Biografia</h6>
    </label>
    <textarea name="biografia" id="biografia" rows="5" cols="30"
        class="form-control @error('biografia') is-invalid @enderror" placeholder="Escreva a biografia...">
        {{ old('biografia', $pessoa->biografia ?? '') }}
    </textarea>
    @error('biografia')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mb-2">
    <label for="genero">
        <h6>Gênero</h6>
    </label>
    <input type="text" name="genero" id="genero" value="{{ old('genero', $pessoa->genero ?? '') }}"
        class="form-control @error('genero') is-invalid @enderror" placeholder="Digite o genero...">
    @error('genero')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mb-2">
    <label for="nacionalidade">
        <h6>Nacionalidade</h6>
    </label>
    <input type="text" name="nacionalidade" id="nacionalidade"
        value="{{ old('nacionalidade', $pessoa->nacionalidade ?? '') }}"
        class="form-control @error('nacionalidade') is-invalid @enderror" placeholder="Digite o nacionalidade...">
    @error('nacionalidade')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="profissoes[]">
        <h6>Profissão(ões)</h6>
    </label>
    <div class="form-check form-switch">
        <input class="form-check-input" name="profissoes[]" type="checkbox" value="1"
            {{ isset($pessoa) && $pessoa->actor ? 'checked' : '' }} role="switch" id="ator">
        {{-- {{ in_array($genero->id, old('generos', $filme->genres->pluck('id')->toArray())) ? 'checked' : '' }}> --}}
        <label class="form-check-label" for="ator">
            Ator
        </label>
    </div>
    <div class="form-check form-switch">
        <input class="form-check-input" name="profissoes[]" type="checkbox" value="2"
            {{ isset($pessoa) && $pessoa->director ? 'checked' : '' }} role="switch" id="diretor">
        <label class="form-check-label" for="diretor">
            Diretor
        </label>
    </div>
    <div class="form-check form-switch">
        <input class="form-check-input" name="profissoes[]" type="checkbox" value="3"
            {{ isset($pessoa) && $pessoa->producer ? 'checked' : '' }} role="switch" id="produtor">
        <label class="form-check-label" for="produtor">
            Produtor
        </label>
    </div>
    <div class="form-check form-switch">
        <input class="form-check-input" name="profissoes[]" type="checkbox" value="4"
            {{ isset($pessoa) && $pessoa->writer ? 'checked' : '' }} role="switch" id="escritor">
        <label class="form-check-label" for="escritor">
            Escritor
        </label>
    </div>
</div>


{{-- Na partial form-filme.blade.php --}}
@if (isset($pessoa))
    <div class="mb-3">
        <label class="form-label fw-bold">Filmes vinculadas</label>
        @foreach ([
        'actor' => ['label' => 'Ator', 'temPersonagem' => true],
        'director' => ['label' => 'Diretor', 'temPersonagem' => false],
        'producer' => ['label' => 'Produtor', 'temPersonagem' => false],
        'writer' => ['label' => 'Escritor', 'temPersonagem' => false],
    ] as $relacao => $config)
            @if ($pessoa->$relacao)
                @foreach ($pessoa->$relacao->movies as $filme)
                    <div class="d-flex align-items-center gap-2 mb-2 card-vinculo-existente">
                        <span class="badge bg-secondary">{{ $config['label'] }}</span>
                        <span>{{ $filme->nome }}</span>
                        @if ($config['temPersonagem'])
                            <input type="text" name="atores_existentes[{{ $filme->id }}][personagem]"
                                value="{{ $filme->pivot->papel }}" class="form-control form-control-sm"
                                style="width:180px" placeholder="Personagem">
                        @endif
                        {{-- Marcador para remoção --}}
                        <input type="checkbox" name="remover_vinculos[{{ $relacao }}][]"
                            value="{{ $filme->id }}" class="form-check-input" title="Remover">
                        <label class="form-check-label text-danger small">Remover</label>
                    </div>
                @endforeach
            @endif
        @endforeach
    </div>
@endif


{{-- Seção de vínculos na partial form-filme.blade.php --}}
<div class="mb-4">
    <label class="form-label fw-bold">Filmes vinculados</label>
    {{-- Container onde os cards de vínculo são inseridos --}}
    <div id="vinculos-container"></div>
    <button type="button" id="btn-vincular" class="btn btn-outline-dark btn-sm mt-2">
        + Vincular filme
    </button>
</div>

{{-- Template de um card de vínculo (oculto, clonado pelo JS) --}}
<template id="template-vinculo">
    <div class="card mb-2 card-vinculo">
        <div class="card-body p-2">
            {{-- Campo de busca visível + campo oculto com o ID --}}
            <input type="text" class="form-control mb-2 campo-busca" placeholder="Buscar pelo nome do filme...">
            <div class="lista-resultados list-group mb-2"></div>
            <input type="hidden" name="" class="campo-filme-id">
            <b><span class="nome-filme small strong"></span></b>
            <select name="" class="form-select form-select-sm mb-2 campo-tipo" required id="campo-tipo">
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
        {{ isset($pessoa) ? 'Adicionar novas imagens' : 'Imagens' }}
    </label>
    {{-- ... campos dinâmicos de upload (como antes) ... --}}
    {{-- Container que recebe os novos campos --}}
    <div id="campos-imagem">
        <div class="campo-imagem mb-2 d-flex align-items-center gap-2">
            <input type="file" name="imagens[]" class="form-control" accept="image/jpeg,image/png,image/webp">
            <label class="mb-0">
                <input type="radio" name="principal_index" value="0"> Principal
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
@if (isset($pessoa) && $pessoa->images->isNotEmpty())
    <div class="mb-1">
        <label class="form-label fw-bold">Imagens cadastradas</label>
        <div class="d-flex flex-wrap gap-3">
            @foreach ($pessoa->images as $imagem)
                <div class="text-center" style="width: 130px">
                    <img src="{{ asset('storage/' . $imagem->caminho) }}" class="img-thumbnail mb-1"
                        style="height: 90px; object-fit: cover">
                    {{-- Radio para definir como principal --}}
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="principal_imagem_id"
                            value="{{ $imagem->id }}" {{ $imagem->pivot->principal ? 'checked' : '' }}>
                        <label class="form-check-label small">Principal</label>
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
        const containerImagens = document.getElementById('campos-imagem');
        const btnAdicionar = document.getElementById('btn-adicionar');
        let indiceImagens = 1;
        const MAX_FOTOS = 5;
        btnAdicionar.addEventListener('click', () => {
            if (indiceImagens >= MAX_FOTOS) {
                alert('Máximo de ' + MAX_FOTOS + ' imagens.');
                return;
            }
            const div = document.createElement('div');
            div.className = 'campo-imagem mb-2 d-flex align-items-center gap-2';
            div.innerHTML = `
                        <input type="file" name="imagens[]" class="form-control"
                        accept="image/jpeg,image/png,image/webp">
                        <label class="mb-0">
                        <input type="radio" name="principal_index" value="${indiceImagens}"> Principal
                        </label>
                        <button type="button" class="btn btn-sm btn-outline-danger"
                        onclick="this.closest('.campo-imagem').remove()">✕</button>`;
            containerImagens.appendChild(div);
            indiceImagens++;
        });

        // JS dos botões de remoção de imagens =========================================

        document.querySelectorAll('.btn-remover-imagem').forEach(btn => {

            btn.addEventListener('click', () => {

                if (!confirm('Remover esta imagem?')) {
                    return;
                }

                const imagemId = btn.dataset.imagem;
                const pessoaId = @json($pessoa->id ?? null);

                const form = document.getElementById('form-remover-imagem');

                form.action = `/imagens/${imagemId}/pessoa/${pessoaId}`;

                form.submit();
            });

        });

        // JS dos vínculos de pessoas ===================================================

        const pessoaId = {{ $pessoa->id ?? 'null' }};
        const containerVinculos = document.getElementById('vinculos-container');
        const template = document.getElementById('template-vinculo');
        const csrfToken = document.querySelector('input[name="_token"]').content;
        let indiceVinculos = 0;
        document.getElementById('btn-vincular').addEventListener('click', () => {
            const card = template.content.cloneNode(true).querySelector('.card-vinculo');
            // Nomeia os campos com o índice atual
            card.querySelector('.campo-filme-id').name = `vinculos[${indiceVinculos}][filme_id]`;
            card.querySelector('.campo-tipo').name = `vinculos[${indiceVinculos}][tipo]`;
            card.querySelector('.campo-personagem').name = `vinculos[${indiceVinculos}][personagem]`;
            inicializarCard(card);
            containerVinculos.appendChild(card);
            indiceVinculos++;
        });

        function inicializarCard(card) {
            const campoBusca = card.querySelector('.campo-busca');
            const listaResultados = card.querySelector('.lista-resultados');
            let timer;
            // Debounce: aguarda 300ms após o usuário parar de digitar
            campoBusca.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(() => buscarFilmes(campoBusca.value, listaResultados, card), 300);
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

        function buscarFilmes(termo, lista, card) {
            if (termo.length < 2) {
                lista.innerHTML = '';
                return;
            }
            fetch(`/filmes/buscar?q=${encodeURIComponent(termo)}&pessoa_id=${pessoaId ?? ''}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(filmes => {
                    lista.innerHTML = '';
                    if (filmes.length === 0) {
                        lista.innerHTML = '<span class="list-group-item text-muted">Nenhum resultado</span>';
                        return;
                    }
                    filmes.forEach(f => {
                        const item = document.createElement('button');
                        item.type = 'button';
                        item.className = 'list-group-item list-group-item-action';
                        // Avisa se já existe vínculo deste tipo
                        const aviso = f.vinculos.length > 0 ?
                            ` <small class="text-warning">(já vinculado como ${f.vinculos.join(', ')})</small>` :
                            '';
                        item.innerHTML = `${f.nome}${aviso}`;
                        item.addEventListener('click', () => {
                            // Preenche os campos ocultos e exibe o nome selecionado
                            card.querySelector('.campo-filme-id').value = f.id;
                            card.querySelector('.campo-busca').value = '';
                            card.querySelector('.nome-filme').textContent = ' ' + f.nome;
                            lista.innerHTML = ''; // fecha a lista

                            // Exibe as opções de profissões disponíveis de acordo com determinada pessoa
                            const profissoes = [];

                            if (document.getElementById('ator').checked)
                                profissoes.push('ator');

                            if (document.getElementById('diretor').checked)
                                profissoes.push('diretor');

                            if (document.getElementById('produtor').checked)
                                profissoes.push('produtor');

                            if (document.getElementById('escritor').checked)
                                profissoes.push('escritor');

                            const select = card.querySelector('.campo-tipo');

                            select.innerHTML =
                                '<option value="" disabled selected hidden>Trabalhou como...</option>';

                            profissoes.forEach(p => {

                                select.innerHTML +=
                                    `<option value="${p}">${p.charAt(0).toUpperCase()+p.slice(1)}</option>`;

                            });

                        });
                        lista.appendChild(item);
                    });
                })
                .catch(err => console.log(err));
        }

        function reindexarVinculos() {
            containerVinculos.querySelectorAll('.card-vinculo').forEach((card, i) => {
                card.querySelector('.campo-filme-id').name = `vinculos[${i}][filme_id]`;
                card.querySelector('.campo-tipo').name = `vinculos[${i}][tipo]`;
                card.querySelector('.campo-personagem').name = `vinculos[${i}][personagem]`;
            });
            indiceVinculos = containerVinculos.querySelectorAll('.card-vinculo').length;
        }
    </script>
@endpush
