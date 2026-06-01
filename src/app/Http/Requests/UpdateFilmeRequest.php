<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFilmeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Pega o ID da rota (se for update)
        $id = $this->route('filme');
        return [
            'nome' => [
                'required',
                'string',
                // unique na tabela filmes,
                // ignorando o registro com id = $id
                Rule::unique('movies')->ignore($id),
            ],
            'data_lancamento' => 'required|date|after:1888-01-01|before:2099-01-01',
            'classificacao' => 'required|string|max:50',
            'sinopse' => 'nullable|string|max:2000',
            'duracao' => 'required|integer|min:1',
            // Novas imagens — opcionais no update
            'imagens' => 'sometimes|nullable|array|max:5',
            'imagens.*' => 'image|mimes:jpeg,png,webp|max:2048',
            // Índice do poster entre as novas imagens enviadas
            'poster_index' => 'nullable|integer|min:0',
            // ID de imagem existente para definir como poster
            'poster_imagem_id' => 'nullable|integer',
        ];
    }

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
        ];
    }
}
