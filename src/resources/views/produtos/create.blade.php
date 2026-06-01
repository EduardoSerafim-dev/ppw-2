{{-- 1. Indica qual layout usar --}}
@extends('layouts.app')
{{-- 2. Preenche o título da aba do navegador --}}
@section('titulo', 'Criando Produto')
{{-- 3. Preenche a região principal do layout --}}
@section('conteudo')

    <form action="/produtos" method="post">
        @csrf
        <div class="form-group mb-3">
            <label for="nome">Nome: </label>
            <input type="text" class="form-control" name="nome" placeholder="Digite o nome do produto">
        </div>
        <div class="form-group mb-3">
            <label for="preco">Preço: </label>
            <input type="number" class="form-control" name="preco" placeholder="Digite o preço do produto">
        </div>
        <button type="submit" class="btn btn-primary">Criar produto</button>
    </form>

@endsection
