@extends('layouts.app')

@section('titulo', 'Página inicial')

@section('conteudo')

    <div style="text-align: center; border; margin: 5%;" class="shadow rounded p-3">

        <h1 class="mt-4">CineReview</h1>
        <h5 class="mt-3 mb-4 p-2">
            Bem vindo, procure por filmes, atores, diretores, produtores, estúdios e faça sua avalição!</h5>
    </div>

    @include('partials.carousel')
    @include('partials.cards-atores')
    @include('partials.cards-filmes')



    {{-- <a href="/filmes/{{ 1 }}" class="btn btn-primary">
        Visualizar este filme
    </a> --}}


@endsection

{{-- <form action="/dados" method="post">
        <input type="submit" value="Clicar">
    </form>

    <form action="/produtos" method="post">
        @csrf

        <label for="nome">Nome: </label>
        <input type="text" name="nome">

        <label for="preco">Preço: </label>
        <input type="number" name="preco">

        <input type="submit" value="Cadastrar Produto">
    </form>

    <form action="/produtos/2" method="post">
        @csrf
        @method('DELETE')
        <input type="submit" value="Deletar Produto">
    </form>

    <form action="/produtos/7" method="post">
        @csrf
        @method('PUT')
        <input type="submit" value="Atualizar Produto">
    </form>

    <form action="/produtos/" method="post">
        @csrf
        @method('PUT')
        <input type="submit" value="Atualizar Produto">
    </form> --}}
