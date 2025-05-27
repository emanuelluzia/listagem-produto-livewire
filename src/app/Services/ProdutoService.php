<?php

namespace App\Services;

use App\Models\Produto;
use Illuminate\Pagination\LengthAwarePaginator;

class ProdutoService
{
    public function __construct(private Produto $produtoModel) {}

    public function listarProdutos(
        int $perPage = 10, 
        ?string $search = null,
        ?float $preco = null,
        ?int $estoque = null
        ): LengthAwarePaginator
    {
                
        return $this->produtoModel
            ->when($search, fn($query) =>
                $query->where('nome', 'like', "%{$search}%")
            )
            ->when($preco, fn($query) =>
                $query->where('preco', $preco)
            )
            ->when($estoque, fn($query) =>
                $query->where('quantidade_estoque', $estoque)
            )
            ->paginate($perPage);
    }

    public function criarProduto(array $dados): Produto
    {
        return $this->produtoModel->create($dados);
    }

    public function atualizarProduto(Produto $produto, array $dados): bool
    {
            if ($produto->nome === $dados['nome']) {
                unset($dados['nome']);
            }
        return $produto->update($dados);
    }

    public function deletarProduto(Produto $produto): bool
    {
        return $produto->delete();
    }

    public function encontrarProduto(int $id): ?Produto
    {
        return $this->produtoModel->find($id);
    }
}