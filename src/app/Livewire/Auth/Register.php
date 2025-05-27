<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $error;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'password' => 'required|min:6|same:password_confirmation',
    ];

    public function register()
    {
        $this->validate();

        $response = Http::post('http://172.17.0.1:8000/api/register', [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ]);

        if ($response->successful()) {
            session(['auth_token' => $response['token']]);
            return redirect()->route('products');
        }

        $this->error = 'Erro ao registrar. Verifique os dados e tente novamente.';
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.guest');
    }
}
