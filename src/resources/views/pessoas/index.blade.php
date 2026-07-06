@extends('layouts.app')

@section('titulo', 'Pessoas')

@section('conteudo')

    <h1 class="d-flex justify-content-center mb-4 mt-4">Lista de Pessoas</h1>

    <div class="d-flex justify-content-end mb-4">
        <a href="/pessoas/create" class="btn btn-success mx-4">
            + Criar Nova Pessoa
        </a>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-2 mb-4">
        @foreach ($pessoas as $pessoa)
            <div class="col">
                <div class="card">
                    <div class="card-body d-flex gap-1">
                        <a class="card-title h-5 mx-2" href="/pessoas/{{ $pessoa->id }}"> {{ $pessoa->nome }}</a>
                        <a href="/pessoas/{{ $pessoa->id }}" class="btn btn-dark">
                            <i class="bi bi-info-circle"></i> Visualizar esta pessoa
                        </a>
                        <a class="btn btn-warning" href="/pessoas/{{ $pessoa->id }}/edit">Editar</a>
                        <form action="/pessoas/{{ $pessoa->id }}" method="POST"
                            onsubmit="return confirm('Remover esta pessoa?')">
                            @csrf
                            @method('DELETE') {{-- Spoofing: o HTML só suporta GET e POST --}}
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
