<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Lista de Produtos</h1>
  <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <!-- Área de busca -->
        <div class="flex-1 flex items-center gap-2">
            <input type="text"
                placeholder="Buscar por nome"
                wire:model.debounce.500ms="search"
                wire:keydown.enter="loadProducts"
                class="w-full px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
            <input x-data
                placeholder="Filtrar por Preço"
                 x-init="new AutoNumeric($el, { 
                                decimalCharacter: ',', 
                                digitGroupSeparator: '.', 
                                decimalPlaces: 2,
                                unformatOnSubmit: true
                            })"
                wire:model.lazy="precoFiltro"
                class="w-full border px-3 py-2 rounded" />
            <input type="text"
                placeholder="Filtrar por estoque"
                wire:model.debounce.500ms="estoque"
                wire:keydown.enter="loadProducts"
                class="w-full px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                oninput="this.value = this.value.replace(/[^0-9.]/g, '')" />
            <button wire:click="loadProducts"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition whitespace-nowrap">
                <span class="hidden md:inline">Filtrar</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:hidden" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                </svg>
            </button>
            <button wire:click="clearFilters"
                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition whitespace-nowrap">
                Limpar
            </button>

        </div>

        <div class="flex gap-2">
            <button wire:click="$dispatch('createProduct')" 
                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition whitespace-nowrap">
                + Novo Produto
            </button>
            <button wire:click="logout" 
                    class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition whitespace-nowrap">
                Sair
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2">{{ $product['nome'] }}</h2>
                    <p class="text-gray-600 mb-4">{{ $product['descricao'] }}</p>
                    <p class="text-gray-600 mb-4">Quantidade:{{ $product['quantidade_estoque'] }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-blue-600">R$ {{ number_format($product['preco'], 2, ',', '.') }}</span>
                      <a wire:click="$dispatch('editProduct', { id: {{ $product['id'] }}} )" 
                        class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                            Editar
                      </a>
                     <button wire:click="deleteProduct({{ $product['id'] }})"
                            onclick="return confirm('Tem certeza que deseja excluir este produto?')"
                            class="px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                        Excluir
                    </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Paginação --}}
    <div class="mt-8 flex justify-center space-x-2">
        @if ($pagination['current_page'] > 1)
            <button wire:click="goToPage({{ $pagination['current_page'] - 1 }})"
                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                Anterior
            </button>
        @endif

        @for ($i = 1; $i <= $pagination['last_page']; $i++)
            <button wire:click="goToPage({{ $i }})"
                    class="px-4 py-2 rounded {{ $i == $pagination['current_page'] ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                {{ $i }}
            </button>
        @endfor

        @if ($pagination['current_page'] < $pagination['last_page'])
            <button wire:click="goToPage({{ $pagination['current_page'] + 1 }})"
                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                Próxima
            </button>
        @endif 
        <select wire:model="perPage" wire:change="loadProducts">
            <option value="5">5 por página</option>
            <option value="10">10 por página</option>
            <option value="20">20 por página</option>
        </select>
    </div>
    <livewire:product-form />
</div>



