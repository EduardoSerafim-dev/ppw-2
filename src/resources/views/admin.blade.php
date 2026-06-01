@extends('layouts.app')

@section('titulo', 'Página Admin')

@section('conteudo')

    <h1 class="d-flex justify-content-center mt-4">Página do Admin</h1>

    <br> <br>

    {{-- Exibindo conteúdo condicional no Blade --}}
    @auth
        @if (auth()->user()->isAdmin())
            <a href="/filmes/create" class="btn btn-success">
                + Novo Filme
            </a>
            <a href="/pessoas/create" class="btn btn-success">
                + Nova Pessoa
            </a>
            <a href="/estudios/create" class="btn btn-success">
                + Novo Estúdio
            </a>
            <a href="/generos/create" class="btn btn-success">
                + Novo Gênero
            </a>
        @endif
        <p>Olá, {{ auth()->user()->name }}!</p>
        <a href="/perfil">Meu Perfil</a>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit">Sair</button>
        </form>
    @endauth
    @guest
        <a href="/login">Entrar</a>
        <a href="/register">Cadastrar</a>
    @endguest
    {{-- Exibir botão de avaliação só para logados --}}
    @auth
        {{-- <a href="/filmes/{{ $filme->id }}/avaliar" class="btn btn-primary">
            Avaliar este filme
        </a> --}}
        <a href="/filmes/{{ 1 }}" class="btn btn-primary">
            Visualizar este filme
        </a>
    @endauth


@endsection
