@extends('layouts.app')

@section('titulo', 'Avaliação')

@section('conteudo')

    <div style="margin-top: 5%; margin-bottom: 3%">
        <h3 class="d-flex justify-content-center mt-4 mb-4">Avaliação de "{{ $avaliacao->movie->nome }}"</h3>
    </div>

    <div class="d-flex justify-content-center">
        <div class="card mt-4 mb-4 mx-4 col-md-8">
            <div class="card-body">
                <p class="card-text">
                    <strong>Autor: </strong> {{ $avaliacao->user->name }} <br>
                    <strong>Nota: </strong> <span class="badge text-bg-warning"
                        style="width: 60px">{{ $avaliacao->nota }}/10</span>
                    <br>
                    <strong>Descrição: </strong> {{ $avaliacao->descricao }}
                    <br>
                </p>
            </div>
        </div>
    </div>


@endsection
