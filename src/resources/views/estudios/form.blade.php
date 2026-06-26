 <div class="form-group mb-2">
     <label for="nome">
         <h6>Nome: </h6>
     </label>
     <input type="text" name="nome" id="nome" value="{{ old('nome', $estudio->nome ?? '') }}"
         class="form-control @error('nome') is-invalid @enderror" placeholder="Escreva o nome do estúdio...">
     @error('nome')
         <div class="invalid-feedback">{{ $message }}</div>
     @enderror
 </div>
 <div class="form-group mb-3">
     <label for="local">
         <h6>Local: </h6>
     </label>
     <textarea name="local" id="local" rows="5" cols="30"
         class="form-control @error('local') is-invalid @enderror" placeholder="Informe onde fica a estúdio...">
{{-- old() para textarea fica entre as tags, não no value --}}
        {{ old('local', $estudio->local ?? '') }}
    </textarea>
     @error('local')
         <div class="invalid-feedback">{{ $message }}</div>
     @enderror
 </div>

 <div class="mb-1">
     <label class="form-label fw-bold">
         {{ isset($estudio) ? 'Adicionar novas imagens' : 'Imagens' }}
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
