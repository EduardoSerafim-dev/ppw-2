<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFilmeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    //  Quem pode fazer esta requisição?
    // true = qualquer usuário autenticado
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    // Regras de validação
    public function rules(): array
    {
        return [
            'nome' => 'required|string|min:2|max:255',
            'duracao' => 'required|integer|min:1',
            'data_lancamento' => 'required|date|after:1888-01-01|before:2099-01-01',
            'classificacao' => 'required|string|max:50',
            'sinopse' => 'nullable|string|max:2000',
            // Poster obrigatório no cadastro
            // 'poster' => 'required|image|mimes:jpeg,png,webp|max:2048',
            'imagens' => 'required|array|min:1|max:5',
            'imagens.*' => 'image|mimes:jpeg,png,webp|max:2048',
            // Valida o índice do poster
            'poster_index' => 'nullable|integer|min:0',
            // 'generos' => 'required|array|min:1',
            // 'generos.*' => 'exists:genres,id',

            // Regras comuns (Store e Update):
            'vinculos' => 'nullable|array',
            'vinculos.*.pessoa_id' => 'required_with:vinculos|integer|exists:people,id',
            'vinculos.*.tipo' => 'required_with:vinculos|in:ator,diretor,produtor,escritor',
            'vinculos.*.personagem' => 'nullable|string|max:100',
        ];
    }

    // Mensagens personalizadas (opcional)
    public function messages(): array
    {
        return [
            'nome.required' => 'O título é obrigatório.',
            'data_lancamento.required' => 'A data de lançamento é obrigatória.',
            'data_lancamento.after' => 'O cinema existe desde 1888.',
            'data_lancamento.before' => 'Ano inválido.',
            'duracao.required' => 'A duração é obrigatória.',
            'duracao.min' => 'Duração muito curta.',
            'classificacao.required' => 'A classificação é obrigatória.',
            'imagens.required' => 'Envie ao menos uma imagem.',
            'imagens.max' => 'Máximo de 5 imagens por vez.',
            'imagens.*.image' => 'Todos os arquivos devem ser imagens.',
            'imagens.*.max' => 'Cada imagem pode ter no máximo 2 MB.',
            'generos.required' => 'Selecione ao menos um gênero para o filme.',
            // 'poster.required' => 'O poster é obrigatório.',
        ];
    }
}
