<?php
namespace Tests\Feature;

use App\Models\Produto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;


class ProdutoApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_listagem_de_produtos()
    {
        // Autentica o usuário
        Sanctum::actingAs(User::factory()->create());

        Produto::factory()->count(3)->create();

        $response = $this->getJson('/api/produtos');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data', 'meta']);
    }

    public function test_criacao_de_produto()
    {
        Sanctum::actingAs(User::factory()->create());

        $dados = [
            'nome' => 'Novo Produto',
            'descricao' => 'Teste',
            'preco' => 99.99,
            'quantidade_estoque' => 10,
        ];

        $response = $this->postJson('/api/produtos', $dados);

        $response->assertStatus(201)
                 ->assertJsonFragment(['nome' => 'Novo Produto']);
    }

    public function test_remocao_de_produto()
    {
        Sanctum::actingAs(User::factory()->create());

        $produto = Produto::factory()->create();

        $response = $this->deleteJson("/api/produtos/{$produto->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('produtos', ['id' => $produto->id]);
    }
}