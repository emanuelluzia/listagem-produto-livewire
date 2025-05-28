<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProdutoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pode_criar_produto_com_campos_obrigatorios()
    {
        $produto = Produto::create([
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição teste',
            'preco' => 10.99,
            'quantidade_estoque' => 100
        ]);

        $this->assertDatabaseHas('produtos', [
            'id' => $produto->id,
            'nome' => 'Produto Teste',
            'preco' => 10.99
        ]);
    }

    /** @test */
    public function verifica_campos_fillable()
    {
        $fillable = [
            'nome',
            'descricao',
            'preco',
            'quantidade_estoque'
        ];
        
        $produto = new Produto();
        
        $this->assertEquals($fillable, $produto->getFillable());
    }

    /** @test */
    public function nome_e_obrigatorio()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Produto::create([
            'descricao' => 'Descrição',
            'preco' => 10.99,
            'quantidade_estoque' => 100
        ]);
    }

    /** @test */
    public function preco_e_obrigatorio()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Produto::create([
            'nome' => 'Produto sem preço',
            'descricao' => 'Descrição',
            'quantidade_estoque' => 100
        ]);
    }

    public function nao_pode_criar_produto_com_nome_duplicado()
    {
        Produto::create([
            'nome' => 'Produto Unico',
            'descricao' => 'Primeiro',
            'preco' => 9.99,
            'quantidade_estoque' => 10
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Produto::create([
            'nome' => 'Produto Unico',
            'descricao' => 'Segundo',
            'preco' => 12.99,
            'quantidade_estoque' => 5
        ]);
        }
}