<?php

namespace App\Livewire;

use App\Http\Requests\ProdutoRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class ProductForm extends Component
{
    public $id;
    public $nome;
    public $descricao;
    public $preco;
    public $quantidade_estoque;
    public $isEditing = false;
    public $showModal = false;

    protected $rules = [
        'nome' => 'required|min:3',
        'descricao' => 'required|min:5',
        'preco' => 'required',
        'quantidade_estoque' => 'required|integer|min:0',
    ];

    protected $listeners = [
            'editProduct' => 'editProduct',
            'createProduct' => 'createProduct',
            'cancelForm' => 'cancelForm'
    ];
    
    public function messages()
    {
        return (new ProdutoRequest())->messages();
    }

      public function mount()
    {
        $this->showModal = false; 
    }

    public function createProduct()
    {
        $this->reset(['id', 'nome', 'descricao', 'preco','quantidade_estoque']);
        $this->showModal = true;
        $this->isEditing = false;
    }

    public function editProduct($id)
    {   
        $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' .  session('auth_token'),
                    'Accept' => 'application/json',
        ])->get("http://172.17.0.1:8000/api/produtos/{$id}");

        if ($response->successful()) {
            $this->showModal = true;
            $product = $response->json();
            $this->id = $product['id'];
            $this->nome = $product['nome'];
            $this->descricao = $product['descricao'];
            $this->preco = $product['preco'];
            $this->quantidade_estoque = $product['quantidade_estoque'];
            $this->isEditing = true;
        }elseif ($response->status() === 401) {
            session()->forget('auth_token');
            redirect()->route('login');
        }
    }

    public function save()
    {
        $this->validate();
        $preco = floatval($this->preco);
        $preco = str_replace(',', '.',$this->preco);
        

        $data = [
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'preco' => $preco,
            'quantidade_estoque' => $this->quantidade_estoque,
        ];
        $headers = [
            'Authorization' => 'Bearer ' . session('auth_token'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        if ($this->isEditing) {
            $response = Http::withHeaders($headers)
                ->put("http://172.17.0.1:8000/api/produtos/{$this->id}", $data);
        } else {
            $response = Http::withHeaders($headers)
                ->post("http://172.17.0.1:8000/api/produtos", $data);
        }

        if ($response->successful()) {
            $this->dispatch('productSaved');
            session()->flash('message', 'Produto salvo com sucesso.');
            $this->reset();
        } else {
            $erro = $response->json('message');
            session()->flash('error', 'Erro ao salvar produto: ' . $erro);
        }
    }

    public function cancelForm()
    {
        $this->showModal = false;
        $this->reset(['id', 'nome', 'descricao', 'preco', 'quantidade_estoque', 'isEditing']);
    }

    public function render()
    {
        return view('livewire.product-form');
    }
}
