<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePessoaRequest extends FormRequest
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
            'cpf' => 'required|string|min:1|max:255',
            'data_nascimento' => 'required|date|after:1888-01-01|before:2099-01-01',
            'biografia' => 'nullable|string|max:2000',

            // Novas imagens — opcionais no update
            'imagens' => 'sometimes|nullable|array|max:5',
            'imagens.*' => 'image|mimes:jpeg,png,webp|max:2048',
            // Índice do poster entre as novas imagens enviadas
            'principal_index' => 'nullable|integer|min:0',
            // ID de imagem existente para definir como poster
            'principal_imagem_id' => 'nullable|integer',

            'genero' => 'required|string|min:1|max:255',
            'nacionalidade' => 'required|string|min:1|max:255',
            'profissoes' => 'required|array|min:1',

            // Regras comuns (Store e Update):
            'vinculos' => 'nullable|array',
            'vinculos.*.filme_id' => 'required_with:vinculos|integer|exists:movies,id',
            'vinculos.*.tipo' => 'required_with:vinculos|in:ator,diretor,produtor,escritor',
            'vinculos.*.personagem' => 'nullable|string|max:100',

            // Regras adicionais apenas no Update:
            'remover_vinculos' => 'nullable|array',
            'remover_vinculos.atores' => 'nullable|array',
            'remover_vinculos.atores.*' => 'integer|exists:actors,id',
            'remover_vinculos.diretores' => 'nullable|array',
            'remover_vinculos.diretores.*' => 'integer|exists:directors,id',
            'remover_vinculos.produtores' => 'nullable|array',
            'remover_vinculos.produtores.*' => 'integer|exists:producers,id',
            'remover_vinculos.escritores' => 'nullable|array',
            'remover_vinculos.escritores.*' => 'integer|exists:writers,id',
            'atores_existentes' => 'nullable|array',
            'atores_existentes.*.personagem' => 'nullable|string|max:100',
        ];
    }

    // Mensagens personalizadas (opcional)
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do ator é obrigatório.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_lancamento.after' => 'O cinema existe desde 1888.',
            'data_lancamento.before' => 'Ano inválido.',
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
