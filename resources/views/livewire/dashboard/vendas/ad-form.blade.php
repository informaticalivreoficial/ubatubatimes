<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

    <h1 class="text-xl font-bold mb-4">
        {{ $ad ? 'Editar' : 'Novo' }} Anúncio
    </h1>

    <form wire:submit.prevent="save" class="space-y-4">

        <select wire:model="company_id" class="w-full border p-2 rounded">
            <option value="">Empresa</option>
            @foreach($companies as $id => $alias_name)
                <option value="{{ $id }}">{{ $alias_name }}</option>
            @endforeach
        </select>

        <select wire:model="plan_id" class="w-full border p-2 rounded">
            <option value="">Plano</option>
            @foreach($plans as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>

        <select wire:model="ad_contract_id" class="w-full border p-2 rounded">
            <option value="">Contrato</option>
            @foreach($contracts as $id => $name)
                <option value="{{ $id }}">#{{ $id }}</option>
            @endforeach
        </select>

        <input type="text" wire:model="title" placeholder="Título" class="w-full border p-2 rounded">

        <input type="url" wire:model="link" placeholder="Link" class="w-full border p-2 rounded">

        <input type="date" wire:model="start_date" class="w-full border p-2 rounded">
        <input type="date" wire:model="end_date" class="w-full border p-2 rounded">

        <input type="file" wire:model="image">

        @if($image)
            <img src="{{ $image->temporaryUrl() }}" class="h-24">
        @elseif($ad?->image)
            <img src="{{ asset('storage/' . $ad->image) }}" class="h-24">
        @endif

        <label class="flex items-center gap-2">
            <input type="checkbox" wire:model="active">
            Ativo
        </label>

        <button class="bg-green-500 text-white px-4 py-2 rounded">
            Salvar
        </button>

    </form>
</div>