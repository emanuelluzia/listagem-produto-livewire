<div>
    @if ($showModal)

        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">{{ $isEditing ? 'Editar Produto' : 'Novo Produto' }}</h2>

                @if (session()->has('message'))
                    <div class="text-green-600">{{ session('message') }}</div>
                @endif
                @if (session()->has('error'))
                    <div class="text-red-600">{{ session('error') }}</div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label class="block">Nome</label>
                        <input type="text" wire:model="nome" class="w-full border px-3 py-2 rounded" />
                        @error('nome') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block">Descrição</label>
                        <textarea wire:model="descricao" class="w-full border px-3 py-2 rounded"></textarea>
                        @error('descricao') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block">Preço</label>
            
                        <input x-data
                             x-init="new AutoNumeric($el, { 
                                decimalCharacter: ',', 
                                digitGroupSeparator: '.', 
                                decimalPlaces: 2,
                                unformatOnSubmit: true
                            })"
                            wire:model.lazy="preco"
                            class="w-full border px-3 py-2 rounded" />
                            @error('preco') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block">Quantidade</label>
                        <input type="number" wire:model="quantidade_estoque" step="0.01" class="w-full border px-3 py-2 rounded" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" />
                        @error('quantidade_estoque') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-2">
                    <button wire:click="$dispatch('cancelForm')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</button>
                    <button wire:click="save" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Salvar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>