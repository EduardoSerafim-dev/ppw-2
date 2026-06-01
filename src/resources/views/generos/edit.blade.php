@extends('layouts.app')

@section('titulo', 'Editar: ' . $genero->nome)

@section('conteudo')

    <style>
        .botao-salvar {

            background-color: white
        }


        .botao-salvar:hover {

            background-color: black;
        }
    </style>

    <h1 class="d-flex justify-content-center mb-1 mt-4">Editar Gênero</h1>

    <form action="/generos/{{ $genero->id }}" method="POST" enctype="multipart/form-data"
        style="background-color:#a0d6fa;  margin: 2% 25% 5% 25%; padding: 1rem; border-radius: 10px">
        @csrf
        @method('PUT') {{-- Spoofing: o HTML só suporta GET e POST --}}
        @include('generos.form', ['genero' => $genero])
        <div class="d-flex justify-content-center" style="border-top: solid 0.5px white; padding-top: 2%">
            <button type="submit" class="botao-salvar btn btn-outline-dark">Salvar</button>
        </div>
    </form>

@endsection
