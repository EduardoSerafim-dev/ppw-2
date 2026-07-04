<h4 class="d-flex justify-content-center mb-1 mt-1">Deixe sua avaliação:</h4>

<div class="form-group mb-2">
    <label for="nota">
        <h6>Nota: </h6>
    </label>
    <input type="number" name="nota" id="nota" value="{{ old('nota', $avaliacao->nota ?? '') }}"
        class="form-control @error('nota') is-invalid @enderror" placeholder="Dê uma nota ao filme... de 0 a 10">
    @error('nota')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="descricao">
        <h6>Descrição: </h6>
    </label>
    <textarea name="descricao" id="descricao" rows="5" cols="30"
        class="form-control @error('descricao') is-invalid @enderror" placeholder="Faça a descrição de sua crítica...">
{{-- old() para textarea fica entre as tags, não no value --}}
        {{ old('descricao', $avaliacao->descricao ?? '') }}
    </textarea>
    @error('descricao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
