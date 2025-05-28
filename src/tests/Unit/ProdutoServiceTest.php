<?php

namespace Tests\Unit;

use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class ProdutoServiceTest extends TestCase
{
  use RefreshDatabase;

    private ProdutoService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ProdutoService(new Produto());
    }

    /** @test */
    public function lista_produtos_com_paginacao()
    {
        Produto::factory()->count(15)->create();
        
        $result = $this->service->listarProdutos(10);
        
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(10, $result->perPage());
        $this->assertEquals(15, $result->total());
    }

    /** @test */
    public function filtra_produtos_por_nome()
    {
        Produto::factory()->create(['nome' => 'Produto A']);
        Produto::factory()->create(['nome' => 'Produto B']);
        
        $result = $this->service->listarProdutos(10, 'A');
        
        $this->assertEquals(1, $result->total());
        $this->assertEquals('Produto A', $result->first()->nome);
    }

    /** @test */
    public function filtra_produtos_por_preco()
    {
        Produto::factory()->create(['preco' => 10.50]);
        Produto::factory()->create(['preco' => 20.00]);
        
        $result = $this->service->listarProdutos(10, null, 10.50);
        
        $this->assertEquals(1, $result->total());
        $this->assertEquals(10.50, $result->first()->preco);
    }

    /** @test */
    public function cria_novo_produto()
    {
        $dados = [
            'nome' => 'Novo Produto',
            'descricao' => 'Descrição',
            'preco' => 15.99,
            'quantidade_estoque' => 50
        ];
        
        $produto = $this->service->criarProduto($dados);
        
        $this->assertDatabaseHas('produtos', $dados);
        $this->assertEquals('Novo Produto', $produto->nome);
    }

    /** @test */
    public function atualiza_produto_existente()
    {
        $produto = Produto::factory()->create();
        
        $atualizado = $this->service->atualizarProduto($produto, [
            'nome' => 'Nome Atualizado',
            'preco' => 25.99
        ]);
        
        $this->assertTrue($atualizado);
        $this->assertDatabaseHas('produtos', [
            'id' => $produto->id,
            'nome' => 'Nome Atualizado',
            'preco' => 25.99
        ]);
    }

    /** @test */
    public function deleta_produto_existente()
    {
        $produto = Produto::factory()->create();
        
        $resultado = $this->service->deletarProduto($produto);
        
        $this->assertTrue($resultado);
        $this->assertDatabaseMissing('produtos', ['id' => $produto->id]);
    }
}