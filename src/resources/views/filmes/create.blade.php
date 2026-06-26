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

        /* Cor do placeholder do select*/
        select:invalid {
            color: #777777;
        }

        /* Cor das opções normais */
        option {
            color: #000;
        }
    </style>

    <h1 class="d-flex justify-content-center mb-1 mt-4">Cadastrar Filme</h1>

    <form action="/filmes" method="POST" enctype="multipart/form-data"
        style="background-color:#a0d6fa;  margin: 2% 25% 5% 25%; padding: 1rem; border-radius: 10px">
        @csrf
        @include('filmes.form')
        {{-- Partial sem $filme: old() usará '' como padrão --}}
        <div class="d-flex justify-content-center" style="border-top: solid 0.5px white; padding-top: 2%">
            <button type="submit" class="botao-salvar btn btn-outline-dark">Salvar</button>
        </div>
    </form>

@endsection
