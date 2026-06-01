@extends('layouts.app')

@section('titulo', $avaliacao->user->name)

@section('conteudo')

    <div style="margin-top: 5%; margin-bottom: 3%">
        <h1 class="d-flex justify-content-center mt-4 mb-4">Avaliação de {{ $avaliacao->movie->nome }}</h1>
    </div>

    <div class="card mt-4 mb-4 mx-4">
        <div class="row g-0">
            <div class="col-md-10">
                <div class="card-body">
                    <p class="card-text"><strong>Nota: </strong> {{ $avaliacao->nota }} <br> <br>
                        <strong>Descrição: </strong> {{ $avaliacao->descricao }}
                        <br>
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection
