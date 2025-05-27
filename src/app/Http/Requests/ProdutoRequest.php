<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class ProdutoRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
                'descricao' => 'required|min:5',
                'preco' => 'required|numeric|min:0',
                'quantidade_estoque' => 'required|integer|min:0'
            ];

        $nomeRule = Rule::unique('produtos', 'nome');

        if ($this->produto && $this->produto->id) {
            // Se estiver editando, ignora o ID atual na validação de unicidade
            $nomeRule->ignore($this->produto->id);
        }

        $rules['nome'] = ['required', 'min:3', $nomeRule];

        return $rules;

    }

    public function messages(): array
{
    return [
        'nome.required' => 'O nome é obrigatório.',
        'nome.min' => 'O nome deve ter pelo menos 3 caracteres.',
        'nome.unique' => 'Já existe um produto com esse nome.',

        'descricao.required' => 'A descrição é obrigatória.',
        'descricao.min' => 'A descrição deve ter pelo menos 5 caracteres.',

        'preco.required' => 'O preço é obrigatório.',
        'preco.numeric' => 'O preço deve ser um número.',
        'preco.min' => 'O preço deve ser no mínimo 0.',

        'quantidade_estoque.required' => 'A quantidade em estoque é obrigatória.',
        'quantidade_estoque.integer' => 'A quantidade deve ser um número inteiro.',
        'quantidade_estoque.min' => 'A quantidade mínima é 0.',
    ];
}
}
