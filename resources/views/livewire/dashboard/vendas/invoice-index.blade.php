<div>
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-file-invoice-dollar mr-2"></i> Faturas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Faturas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12 col-sm-6 my-2">
                    <div class="card-tools">
                        <div style="width: 250px;">
                            <div class="input-group input-group-sm">
                                <input type="text" wire:model.live="search" class="form-control float-right" placeholder="Pesquisar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped projects">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th class="text-center">Valor</th>
                        <th class="text-center">Vencimento</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 320px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                    <tr>
                        <td>
                            {{ $invoice->company->alias_name }}
                            @if($invoice->contract?->plan)
                                <br><small class="text-muted">{{ $invoice->contract->plan->name }}</small>
                            @endif
                        </td>
                        <td class="text-center">R$ {{ number_format($invoice->amount, 2, ',', '.') }}</td>
                        <td class="text-center">{{ $invoice->due_date->format('d/m/Y') }}</td>
                        <td class="text-center">
                            @if($invoice->status === 'paid')
                                <span class="badge badge-success">Pago</span>
                            @elseif($invoice->status === 'canceled')
                                <span class="badge badge-secondary">Cancelado</span>
                            @elseif($invoice->isOverdue())
                                <span class="badge badge-danger">Vencido</span>
                            @else
                                <span class="badge badge-warning">Pendente</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                @if($invoice->boleto_url)
                                    <a href="{{ $invoice->boleto_url }}" target="_blank"
                                       class="btn btn-xs btn-primary" title="Ver Boleto">
                                        <i class="fas fa-barcode mr-1"></i> Boleto
                                    </a>
                                @elseif($invoice->status === 'pending')
                                    <button wire:click="generateBoleto({{ $invoice->id }})"
                                            wire:loading.attr="disabled"
                                            class="btn btn-xs btn-info" title="Gerar Boleto">
                                        <i class="fas fa-file-invoice mr-1"></i> Gerar Boleto
                                    </button>
                                @endif

                                @if($invoice->status !== 'paid' && $invoice->status !== 'canceled')
                                    <button wire:click="markAsPaid({{ $invoice->id }})"
                                            class="btn btn-xs btn-success" title="Marcar como Pago">
                                        <i class="fas fa-check mr-1"></i> Pago
                                    </button>

                                    <button wire:click="cancel({{ $invoice->id }})"
                                            wire:confirm="Deseja realmente cancelar esta fatura?"
                                            class="btn btn-xs btn-danger" title="Cancelar">
                                        <i class="fas fa-times mr-1"></i> Cancelar
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Nenhuma fatura encontrada.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
