<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ProductList extends Component
{
    protected $listeners = ['productSaved' => 'loadProducts', 'cancelForm' => 'hideForm'];

    public $products = [];
    public $pagination = [
        'current_page' => 1,
        'last_page' => 1,
    ];
    public $search = '';
    public $precoFiltro = null;
    public $estoque = null;
    public $perPage = 5;
    protected $token;


    
    public function mount()
    {
        $this->token = session('auth_token');

        if (!$this->token) {
            return redirect()->route('login');
        }

        $this->loadProducts();
    }
    
    public function goToPage($page)
    {
        $this->pagination['current_page'] = $page;
        $this->loadProducts();
    }

    public function loadProducts()
    {           

        $precoFiltro = $this->precoFiltro ? str_replace(',', '.',$this->precoFiltro): null;
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('auth_token'),
            'Accept' => 'application/json',
        ])->get("http://172.17.0.1:8000/api/produtos", [
            'page' => $this->pagination['current_page'],
            'per_page' => $this->perPage,
            'search' => $this->search,
            'preco' => $precoFiltro,
            'estoque' => $this->estoque,
        ]);

        if ($response->successful()) {
            $json = $response->json();
            
            $this->products = $json['data'];
            $this->pagination = $json['meta'];
        } else {
             if ($response->status() === 401) {
                 $this->logout();
            }
            $this->products = [];
        }
    }

   public function logout()
    {
        $token = session('auth_token');

        if ($token) {
            Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://172.17.0.1:8000/api/logout');
        }

        session()->forget('auth_token');

        return redirect()->route('login');
    }

    public function updatedSearch()
    {
        $this->pagination['current_page'] = 1; 
        $this->loadProducts();
    }

    public function deleteProduct($id)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('auth_token'),
            'Accept' => 'application/json',
        ])->delete("http://172.17.0.1:8000/api/produtos/{$id}");

        if ($response->successful()) {
            $this->loadProducts();
            session()->flash('message', 'Produto excluído com sucesso!');
        } else {
            session()->flash('error', 'Erro ao excluir o produto.');
        }
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->precoFiltro = '';
        $this->estoque = '';
        $this->pagination['current_page'] = 1;

        $this->loadProducts();
    }

    public function render()
    {
        return view('livewire.product-list')->layout('layouts.guest');
    }
}
