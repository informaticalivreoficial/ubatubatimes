<div>
    @section('title', $title) 
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-search mr-2"></i> Faturas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">                    
                        <li class="breadcrumb-item"><a href="{{route('admin')}}">Painel de Controle</a></li>
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
                            <form class="input-group input-group-sm" action="" method="post">
                                <input type="text" wire:model.live="search" class="form-control float-right" placeholder="Pesquisar">               
                                
                            </form>
                        </div>
                      </div>
                </div>
                <div class="col-12 col-sm-6 my-2 text-right">
                    <a href="{{route('companies.create')}}" class="btn btn-sm btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Novo</a>
                </div>
            </div>
        </div>  

        <div class="card-body">
            <table class="table table-bordered table-striped projects">
                <thead>
                    <tr>
                        <th wire:click="sortBy('alias_name')">Empresa <i class="expandable-table-caret fas fa-caret-down fa-fw"></i></th>
                        <th>Valor</th>
                        <th class="text-center">Vencimento</th>
                        <th class="text-center">Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)                    
                    <tr style="{{ ($invoice->status == true ? '' : 'background: #fffed8 !important;')  }}">                            
                        <td>{{$invoice->company->alias_name}}</td>
                        <td class="text-center">R$ {{ number_format($invoice->amount, 2, ',', '.') }}</td>
                        <td class="text-center">{{ $invoice->due_date->format('d/m/Y') }}</td>
                        <td class="text-center">
                            @if($invoice->status === 'paid')
                                <span class="text-green-600">Pago</span>
                            @elseif($invoice->isOverdue())
                                <span class="text-red-600">Vencido</span>
                            @else
                                <span class="text-yellow-600">Pendente</span>
                            @endif
                        </td>
                        <td>  
                            <div class="flex items-center justify-center gap-1">                              
                                @if($invoice->boleto_url)
                                    <a href="{{ $invoice->boleto_url }}" target="_blank"
                                    class="text-blue-500">
                                        Ver Boleto
                                    </a>
                                @else
                                    <button wire:click="generateBoleto({{ $invoice->id }})"
                                            class="text-blue-500">
                                        Gerar Boleto
                                    </button>
                                @endif

                                @if($invoice->status !== 'paid')
                                    <button wire:click="markAsPaid({{ $invoice->id }})"
                                            class="text-green-600">
                                        Marcar Pago
                                    </button>
                                @endif

                                <button wire:click="cancel({{ $invoice->id }})"
                                        class="text-red-500">
                                    Cancelar
                                </button>                                
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>                
            </table>
        </div> 

    </div>
    
</div>
