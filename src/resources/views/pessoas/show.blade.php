@extends('layouts.app')

@section('titulo', $pessoa->nome)

@section('conteudo')

    <div style="margin-top: 5%; margin-bottom: 3%">
        <h1 class="d-flex justify-content-center mt-4 mb-4">{{ $pessoa->nome }}</h1>
    </div>

    <div class="card mt-4 mb-4 mx-4">
        <div class="row g-0">
            <div class="col-md-2">
                @php
                    $imagem_pessoa = $pessoa->images->first();
                @endphp

                @if ($imagem_pessoa)
                    <img src="{{ asset('storage/' . $imagem_pessoa->caminho) }}" alt="Poster de {{ $pessoa->nome }}"
                        class="img-fluid rounded w-10" title="Imagem de {{ $pessoa->nome }}">
                @else
                    <img src="{{ asset('imagens/sem-poster.jpg') }}" alt="Sem poster" title="Sem poster"
                        class="img-fluid rounded w-10">
                @endif
            </div>
            <div class="col-md-10">
                <div class="card-body">
                    <p class="card-text"><strong>Biografia: </strong> {{ $pessoa->biografia }} <br> <br>
                        <strong>CPF: </strong> {{ $pessoa->cpf }} <br>
                        <strong>Nacionalidade: </strong> {{ $pessoa->nacionalidade }} <br>
                        <strong>Gênero: </strong> {{ $pessoa->genero }} <br>
                        <strong>Data de nascimento: </strong>
                        {{ \Carbon\Carbon::parse($pessoa->data_nascimento)->format('d/m/Y') }} <br>
                        <strong>Profissão(ões): </strong>{{ implode(', ', $profissoes) }}
                        <br>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <h3 style="margin-left: 10%" class="mb-4">Fotos</h3>

    @forelse ($pessoa->images as $imagem)
        <img style="max-width: 15%" src="{{ asset('storage/' . $imagem->caminho) }}" alt="Imagem de {{ $pessoa->nome }}"
            class="img-fluid rounded w-10" title="Imagem de {{ $pessoa->nome }}">
    @empty
        <h5>Sem imagens</h5>
    @endforelse

@endsection
