<div>
    <div class="flex justify-between mb-4">
        <h1 class="text-xl font-bold">Contratos</h1>

        <a href="{{ route('contracts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            Novo Contrato
        </a>
    </div>

    <table class="w-full bg-white rounded shadow">
        <thead>
            <tr class="border-b">
                <th class="p-2">Empresa</th>
                <th class="p-2">Plano</th>
                <th class="p-2">Valor</th>
                <th class="p-2">Período</th>
                <th class="p-2">Status</th>
                <th class="p-2"></th>
            </tr>
        </thead>

        <tbody>
            @foreach($contracts as $contract)
                <tr class="border-b">
                    <td class="p-2">{{ $contract->company->name }}</td>
                    <td class="p-2">{{ $contract->plan->name }}</td>
                    <td class="p-2">R$ {{ number_format($contract->price, 2, ',', '.') }}</td>
                    <td class="p-2">
                        {{ $contract->start_date->format('d/m/Y') }}
                        -
                        {{ $contract->end_date?->format('d/m/Y') ?? '∞' }}
                    </td>
                    <td class="p-2">
                        @if($contract->isRunning())
                            <span class="text-green-600">Ativo</span>
                        @else
                            <span class="text-red-600">Inativo</span>
                        @endif
                    </td>
                    <td class="p-2 flex gap-2">
                        <a href="{{ route('contracts.edit', $contract) }}">Editar</a>

                        <button wire:click="generateInvoice({{ $contract->id }})"
                                class="text-blue-500">
                            Gerar Fatura
                        </button>

                        <button wire:click="delete({{ $contract->id }})"
                                class="text-red-500">
                            Excluir
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>