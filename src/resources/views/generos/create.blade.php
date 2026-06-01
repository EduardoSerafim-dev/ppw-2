@extends('layouts.app')

@section('titulo', 'Criando Filme')

@section('conteudo')

    <style>
        .botao-salvar {

            background-color: white
        }


        .botao-salvar:hover {

            background-color: black;
        }
    </style>

    <h1 class="d-flex justify-content-center mb-1 mt-4">Cadastrar Gênero</h1>

    <form action="/generos" method="POST" enctype="multipart/form-data"
        style="background-color:#a0d6fa;  margin: 2% 25% 5% 25%; padding: 1rem; border-radius: 10px">
        @csrf
        @include('generos.form')
        <div class="d-flex justify-content-center" style="border-top: solid 0.5px white; padding-top: 2%">
            <button type="submit" class="botao-salvar btn btn-outline-dark">+ Adicionar Gênero</button>
        </div>
    </form>

@endsection
