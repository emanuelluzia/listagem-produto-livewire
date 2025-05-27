<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoRequest;
use App\Services\ProdutoService;
use App\Models\Produto;
use Illuminate\Http\JsonResponse;

class ProdutoController extends Controller
{
    public function __construct(private ProdutoService $produtoService) {}

    public function index(): JsonResponse
    {
        $perPage = request('per_page', 10);
        $search = request('search');
        $preco = request('preco');
        $estoque = request('estoque');
        
        $produtos = $this->produtoService->listarProdutos($perPage, $search,$preco, $estoque );
        
        return response()->json([
            'data' => $produtos->items(),
            'meta' => [
                'total' => $produtos->total(),
                'per_page' => $produtos->perPage(),
                'current_page' => $produtos->currentPage(),
                'last_page' => $produtos->lastPage(),
            ]
        ]);
    }

    public function store(ProdutoRequest $request): JsonResponse
    {
        $produto = $this->produtoService->criarProduto($request->validated());
        return response()->json($produto, 201);
    }

    public function show(Produto $produto): JsonResponse
    {
        return response()->json($produto);
    }

    public function update(ProdutoRequest $request, Produto $produto): JsonResponse
    {
        $this->produtoService->atualizarProduto($produto, $request->validated());
        return response()->json($produto);
    }

    public function destroy(Produto $produto): JsonResponse
    {
        $this->produtoService->deletarProduto($produto);
        return response()->json(null, 204);
    }
}