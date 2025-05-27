<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;


class Login extends Component
{
public $email;
    public $password;
    public $remember = false;
    public $error;


    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function login()
    {
        $this->validate();

        $response = Http::post('http://172.17.0.1:8000/api/login', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            session(['auth_token' => $data['token']]);
            return redirect()->route('products');
        }

        $this->error = 'Credenciais inválidas. Por favor, tente novamente.';
    }

    protected function storeToken($token)
    {
        
        if ($this->remember) {
            Cookie::queue('auth_token', $token, 60 * 24 * 30); // 30 dias
        } else {
            Cookie::queue('auth_token', $token, 60); // 1 hora
        }
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.guest');
    }
}
