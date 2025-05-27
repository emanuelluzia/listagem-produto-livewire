<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
    <div class="max-w-md w-full space-y-8">
        <h2 class="text-center text-3xl font-extrabold text-gray-900">Criar conta</h2>

        @if($error)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                {{ $error }}
            </div>
        @endif

        <form class="mt-8 space-y-6" wire:submit.prevent="register">
            <div class="space-y-4">
                <input type="text" wire:model="name" placeholder="Nome" class="w-full border px-3 py-2 rounded" />
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                <input type="email" wire:model="email" placeholder="Email" class="w-full border px-3 py-2 rounded" />
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                <input type="password" wire:model="password" placeholder="Senha" class="w-full border px-3 py-2 rounded" />
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                <input type="password" wire:model="password_confirmation" placeholder="Confirme a senha" class="w-full border px-3 py-2 rounded" />
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700">
                Registrar
            </button>
        </form>
    </div>
</div>
