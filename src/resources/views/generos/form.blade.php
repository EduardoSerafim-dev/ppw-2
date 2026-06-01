 <div class="form-group mb-2">
     <label for="nome">
         <h6>Nome do Gênero</h6>
     </label>
     <input type="text" name="nome" id="nome" value="{{ old('nome', $genero->nome ?? '') }}"
         class="form-control @error('nome') is-invalid @enderror" placeholder="Digite o nome do gênero...">
     @error('nome')
         <div class="invalid-feedback">{{ $message }}</div>
     @enderror
 </div>
