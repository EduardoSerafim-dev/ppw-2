@extends('layouts.app')

@section('titulo', 'Pessoas')

@section('conteudo')

    <h1 class="d-flex justify-content-center mb-4 mt-4">Lista de Pessoas</h1>

    <div class="row row-cols-1 row-cols-md-4 g-2 mb-4">
        @foreach ($pessoas as $pessoa)
            <div class="col">
                <div class="card">
                    <div class="card-body d-flex gap-1">
                        <a class="card-title h-5" href="/pessoas/{{ $pessoa->id }}"> {{ $pessoa->nome }}</a>
                        <form action="/pessoas/{{ $pessoa->id }}" method="POST">
                            @csrf
                            @method('DELETE') {{-- Spoofing: o HTML só suporta GET e POST --}}
                            <button type="submit" class="btn btn-outline-danger">Excluir</button>
                        </form>
                        <a class="btn btn-outline-primary" href="/pessoas/{{ $pessoa->id }}/edit">Editar</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
