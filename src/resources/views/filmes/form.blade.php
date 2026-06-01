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
                {{ in_array($genero->id, old('generos', $filme->genres->pluck('id')->toArray())) ? 'checked' : '' }}>
            <label class="form-check-label" for="genero{{ $genero->id }}">
                {{ $genero->nome }}
            </label>
        </div>
    @endforeach
</div>


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
    <button type="button" id="btn-adicionar" class="btn btn-outline-secondary btn-sm">
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
                    <form action="/imagens/{{ $imagem->id }}/filme/{{ $filme->id }}" method="POST"
                        class="mt-1" onsubmit="return confirm('Remover esta imagem?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                            Remover
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endif
