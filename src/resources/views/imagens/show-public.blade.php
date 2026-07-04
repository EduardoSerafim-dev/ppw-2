@extends('layouts.app')

@section('titulo', $imagem->nome)

@section('conteudo')

    <div class="d-flex justify-content-center my-3">
        <img src="{{ asset('storage/' . $imagem->caminho) }}" alt="{{ $imagem->nome }}" title="{{ $imagem->nome }}"
            class="img-fluid rounded" style="max-width: 70%; object-fit: contain;">
    </div>

@endsection
