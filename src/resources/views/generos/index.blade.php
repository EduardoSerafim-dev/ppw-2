@extends('layouts.app')

@section('titulo', 'Gêneros')

@section('conteudo')

    <h1 class="d-flex justify-content-center mb-4 mt-4">Lista de Gêneros</h1>

    <div class="row row-cols-1 row-cols-md-4 g-2 mb-4">
        @foreach ($generos as $genero)
            <div class="col">
                <div class="card">
                    <div class="card-body d-flex gap-1">
                        <h5 class="card-title"> {{ $genero->nome }}</h5>
                        <form action="/generos/{{ $genero->id }}" method="POST">
                            @csrf
                            @method('DELETE') {{-- Spoofing: o HTML só suporta GET e POST --}}
                            <button type="submit" class="btn btn-outline-danger">Excluir</button>
                        </form>
                        <a class="btn btn-outline-primary" href="/generos/{{ $genero->id }}/edit">Editar</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
