<div>
    <div class="flex justify-between mb-4">
        <h1 class="text-xl font-bold">Anúncios</h1>

        <a href="{{ route('vendas.ads.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            Novo Anúncio
        </a>
    </div>

    <table class="w-full bg-white rounded shadow">
        <thead>
            <tr class="text-left border-b">
                <th class="p-2">Empresa</th>
                <th class="p-2">Plano</th>
                <th class="p-2">Preview</th>
                <th class="p-2">Status</th>
                <th class="p-2"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($ads as $ad)
                <tr class="border-b">
                    <td class="p-2">{{ $ad->company->name }}</td>
                    <td class="p-2">{{ $ad->plan->name }}</td>
                    <td class="p-2">
                        <img src="{{ asset('storage/' . $ad->image) }}" class="h-12">
                    </td>
                    <td class="p-2">
                        @if($ad->isActive())
                            <span class="text-green-600">Ativo</span>
                        @else
                            <span class="text-red-600">Inativo</span>
                        @endif
                    </td>
                    <td class="p-2 flex gap-2">
                        <a href="{{ route('vendas.ads.edit', $ad) }}">Editar</a>
                        <button wire:click="delete({{ $ad->id }})" class="text-red-500">
                            Excluir
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
