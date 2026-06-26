@extends('layouts.app')

@section('titulo', 'Estúdios')

@section('conteudo')

    <h1 class="d-flex justify-content-center mb-4 mt-4">Estúdios</h1>


    <div class="row row-cols-1 row-cols-md-4 g-2 mb-4">
        @forelse ($estudios as $estudio)
            <div class='col'>
                <div class="card">
                    <div class="card-body d-flex gap-1">
                        <img src="{{ asset('storage/' . $estudio->images->first()->caminho) }}"
                            alt="Imagem do estúdio {{ $estudio->nome }}" class="img-fluid rounded" style="max-width: 240px;"
                            title="Imagem do estúdio {{ $estudio->nome }}">
                        <div class="card-title h-5">{{ $estudio->nome }} </div>
                        <p class="card-text">
                            <strong>Local: </strong>{{ $estudio->local }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class='col-12'>
                {{-- Mensagem quando não há resultados --}}
                <div class='alert alert-warning'>
                    Nenhum estudio encontrado
                </div>
            </div>
        @endforelse
    </div>

    <div class="row row-cols-1 row-cols-md-4 g-2 mb-4">
        @foreach ($estudios as $estudio)
            <div class="col">
                <div class="card">
                    <div class="card-body d-flex gap-1">
                        <a class="card-title h-5" href="/avaliacoes/{{ $estudio->id }}">Avaliação de
                            {{ $estudio->user->name }}</a>



                        {{-- CASO O ADMIN SEJA ASSIM: --}}


                        {{-- <form action="/avaliacoes/{{ $estudio->id }}" method="POST">
                            @csrf
                            @method('DELETE') Spoofing: o HTML só suporta GET e POST --}}
                        {{-- <button type="submit" class="btn btn-outline-danger">Excluir</button>
                        </form> --}}
                        {{-- <a class="btn btn-outline-primary" href="/avaliacoes/{{ $estudio->id }}/edit">Editar</a> --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
