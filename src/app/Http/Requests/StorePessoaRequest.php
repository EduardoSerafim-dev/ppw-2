<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePessoaRequest extends FormRequest
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
        return [
            'nome' => 'required|string|min:2|max:255',
            'cpf' => 'required|unique|string|min:1|max:255',
            'data_nascimento' => 'required|date|after:1888-01-01|before:2099-01-01',
            'biografia' => 'nullable|string|max:2000',
            'imagens' => 'required|array|min:1|max:5',
            'imagens.*' => 'image|mimes:jpeg,png,webp|max:2048',
            // Valida o índice do poster
            // 'poster_index' => 'nullable|integer|min:0',
            'genero' => 'required|string|min:1|max:255',
            'nacionalidade' => 'required|string|min:1|max:255',
            'profissoes' => 'required|array|min:1',
        ];
    }

    // Mensagens personalizadas (opcional)
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do ator é obrigatório.',
            'cpf.required' => 'O CPF do ator é obrigatório.',
            'cpf.unique' => 'Esse CPF já pertence a outra pessoa.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'genero.required' => 'O gênero é obrigatório.',
            'nacionalidade.required' => 'A nacionalidade é obrigatória.',
            'imagens.required' => 'Envie ao menos uma imagem.',
            'imagens.max' => 'Máximo de 5 imagens por vez.',
            'imagens.*.image' => 'Todos os arquivos devem ser imagens.',
            'imagens.*.max' => 'Cada imagem pode ter no máximo 2 MB.',
            'profissoes.required' => 'Selecione ao menos uma profissão para a pessoa.',
            // 'poster.required' => 'O poster é obrigatório.',
        ];
    }
}
