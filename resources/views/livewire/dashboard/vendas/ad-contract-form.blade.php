<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

    <h1 class="text-xl font-bold mb-4">
        {{ $contract ? 'Editar' : 'Novo' }} Contrato
    </h1>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-4">

        <div>
            <select wire:model="company_id" class="w-full border p-2 rounded">
                <option value="">Empresa</option>
                @foreach($companies as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
            @error('company_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <select wire:model="plan_id" class="w-full border p-2 rounded">
                <option value="">Plano</option>
                @foreach($plans as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
            @error('plan_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Free --}}
        <label class="flex items-center gap-2">
            <input type="checkbox" wire:model.live="free">
            Contrato Free
        </label>

        {{-- Preço desabilitado se free --}}
        <div>
            <input type="number" step="0.01" wire:model="price"
                   placeholder="Valor"
                   @disabled($free)
                   class="w-full border p-2 rounded {{ $free ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : '' }}">
            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <input type="date" wire:model="start_date" class="w-full border p-2 rounded">
            @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <input type="date" wire:model="end_date" class="w-full border p-2 rounded">
            @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <label class="flex items-center gap-2">
            <input type="checkbox" wire:model="auto_renew">
            Renovação automática
        </label>

        <label class="flex items-center gap-2">
            <input type="checkbox" wire:model="active">
            Ativo
        </label>

        <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
            Salvar
        </button>

    </form>
</div>