<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

    <h1 class="text-xl font-bold mb-4">
        {{ $contract ? 'Editar' : 'Novo' }} Contrato
    </h1>

    <form wire:submit.prevent="save" class="space-y-4">

        <select wire:model="company_id" class="w-full border p-2 rounded">
            <option value="">Empresa</option>
            @foreach($companies as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>

        <select wire:model="plan_id" class="w-full border p-2 rounded">
            <option value="">Plano</option>
            @foreach($plans as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>

        <input type="number" step="0.01" wire:model="price"
               placeholder="Valor"
               class="w-full border p-2 rounded">

        <input type="date" wire:model="start_date" class="w-full border p-2 rounded">
        <input type="date" wire:model="end_date" class="w-full border p-2 rounded">

        <label class="flex items-center gap-2">
            <input type="checkbox" wire:model="auto_renew">
            Renovação automática
        </label>

        <label class="flex items-center gap-2">
            <input type="checkbox" wire:model="active">
            Ativo
        </label>

        <button class="bg-green-500 text-white px-4 py-2 rounded">
            Salvar
        </button>

    </form>
</div>