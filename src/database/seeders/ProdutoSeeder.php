<?php

namespace Database\Seeders;

use App\Models\Produto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         for ($i = 1; $i <= 10; $i++) {
            Produto::create([
                'nome' => 'Produto ' . $i,
                'descricao' => 'Descrição do Produto ' . $i,
                'preco' => $i * 10, 
                'quantidade_estoque' => $i * 5,
            ]);
        }
    }
}
