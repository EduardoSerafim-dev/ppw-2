@extends('layouts.app')

@section('titulo', 'Estúdio:' . $estudio->nome)

@section('conteudo')

    <div style="margin-top: 5%; margin-bottom: 3%">
        <h3 class="d-flex justify-content-center mt-4 mb-4">{{ $estudio->nome }}</h3>
    </div>

    <div class="d-flex justify-content-center">
        <div class="card mt-4 mb-4 mx-4 col-md-8">
            <div class="card-body">
                <p class="card-text">
                    <strong>Local: </strong>{{ $estudio->local }}<br>
                </p>
            </div>
        </div>
    </div>


@endsection
