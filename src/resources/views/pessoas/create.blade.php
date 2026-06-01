@extends('layouts.app')

@section('titulo', 'Criando Pessoa')

@section('conteudo')

    <style>
        .botao-salvar {

            background-color: white
        }


        .botao-salvar:hover {

            background-color: black;
        }
    </style>

    <h1 class="d-flex justify-content-center mb-1 mt-4">Cadastrar Pessoa</h1>

    <form action="/pessoas" method="POST" enctype="multipart/form-data"
        style="background-color:#a0d6fa;  margin: 2% 25% 5% 25%; padding: 1rem; border-radius: 10px">
        @csrf
        @include('pessoas.form')
        {{-- Partial sem $filme: old() usará '' como padrão --}}
        <div class="d-flex justify-content-center" style="border-top: solid 0.5px white; padding-top: 2%">
            <button type="submit" class="botao-salvar btn btn-outline-dark">Salvar</button>
        </div>
    </form>

    @push('scripts')
        <script>
            const container = document.getElementById('campos-imagem');
            const btnAdicionar = document.getElementById('btn-adicionar');
            let indice = 1;
            const MAX_FOTOS = 5;
            btnAdicionar.addEventListener('click', () => {
                if (indice >= MAX_FOTOS) {
                    alert('Máximo de ' + MAX_FOTOS + ' imagens.');
                    return;
                }
                const div = document.createElement('div');
                div.className = 'campo-imagem mb-2 d-flex align-items-center gap-2';
                div.innerHTML = `
                        <input type="file" name="imagens[]" class="form-control"
                        accept="image/jpeg,image/png,image/webp">
                        <label class="mb-0">
                        <input type="checkbox" name="poster_index" value="${indice}"> Poster
                        </label>
                        <button type="button" class="btn btn-sm btn-outline-danger"
                        onclick="this.closest('.campo-imagem').remove()">✕</button>`;
                container.appendChild(div);
                indice++;
            });
        </script>
    @endpush

@endsection
