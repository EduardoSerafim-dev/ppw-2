@extends('layouts.app')

@section('titulo', 'Avaliações')

@section('conteudo')

    <h1 class="d-flex justify-content-center mb-4 mt-4">Lista de Avaliações</h1>

    <div class="row row-cols-1 row-cols-md-4 g-2 mb-4">
        @foreach ($avaliacoes as $avaliacao)
            <div class="col">
                <div class="card">
                    <div class="card-body d-flex gap-1">
                        <a class="card-title h-5" href="/avaliacoes/{{ $avaliacao->id }}">Avaliação de
                            {{ $avaliacao->user->name }}</a>
                        <form action="/avaliacoes/{{ $avaliacao->id }}" method="POST">
                            @csrf
                            @method('DELETE') {{-- Spoofing: o HTML só suporta GET e POST --}}
                            <button type="submit" class="btn btn-outline-danger">Excluir</button>
                        </form>
                        <a class="btn btn-outline-primary" href="/avaliacoes/{{ $avaliacao->id }}/edit">Editar</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
