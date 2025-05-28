<?php

namespace Tests\Unit\Requests;

use Tests\TestCase;
use App\Http\Requests\ProdutoRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProdutoRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    /** @test */
    public function valida_campos_obrigatorios()
    {
        $request = new ProdutoRequest();
        $rules = $request->rules();

        $this->assertArrayHasKey('nome', $rules);
        $this->assertArrayHasKey('preco', $rules);
        $this->assertArrayHasKey('quantidade_estoque', $rules);

        $this->assertTrue($this->containsRule($rules['nome'], 'required'));
        $this->assertTrue($this->containsRule($rules['preco'], 'required'));
        $this->assertTrue($this->containsRule($rules['quantidade_estoque'], 'required'));
    }

    // Função auxiliar
    private function containsRule($rule, string $expected): bool
    {
        if (is_array($rule)) {
            foreach ($rule as $r) {
                if ((string) $r === $expected || (is_string($r) && str_contains($r, $expected))) {
                    return true;
                }
            }
        } elseif (is_string($rule)) {
            return in_array($expected, explode('|', $rule));
        }

        return false;
    }


    /** @test */
    public function valida_tipos_de_dados()
    {
        $this->artisan('migrate'); 

        $data = [
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição',
            'preco' => 'invalid',
            'quantidade_estoque' => 'abc'
        ];
        
        $validator = Validator::make($data, (new ProdutoRequest())->rules());
        
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('preco', $validator->errors()->toArray());
        $this->assertArrayHasKey('quantidade_estoque', $validator->errors()->toArray());
    }

    /** @test */
    public function aceita_dados_validos()
    {
        $this->artisan('migrate'); 

        $data = [
            'nome' => 'Produto Válido',
            'descricao' => 'Descrição válida',
            'preco' => 10.99,
            'quantidade_estoque' => 50
        ];
        
        $validator = Validator::make($data, (new ProdutoRequest())->rules());
        
        $this->assertFalse($validator->fails());
    }
}
