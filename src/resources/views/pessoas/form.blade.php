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
    <input type="text" name="cpf" id="nome" value="{{ old('cpf', $pessoa->cpf ?? '') }}"
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
{{-- old() para textarea fica entre as tags, não no value --}}
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
