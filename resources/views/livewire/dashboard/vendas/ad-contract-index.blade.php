<div>
    @section('title', $title) 
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-search mr-2"></i> Contratos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">                    
                        <li class="breadcrumb-item"><a href="{{route('admin')}}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Contratos</li>
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
                    <a href="{{route('vendas.contracts.create')}}" class="btn btn-sm btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Novo</a>
                </div>
            </div>
        </div>  

        <div class="card-body">
            <table class="table table-bordered table-striped projects">
                <thead>
                    <tr>
                        <th wire:click="sortBy('alias_name')">Empresa <i class="expandable-table-caret fas fa-caret-down fa-fw"></i></th>
                        <th class="text-center">Plano</th>
                        <th class="text-center">Valor</th>
                        <th class="text-center">Período</th>
                        <th class="text-center">Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contracts as $contract)                   
                    <tr style="{{ ($contract->isRunning() ? '' : 'background: #fffed8 !important;')  }}">                            
                        <td>{{$contract->company->alias_name}}</td>
                        <td class="text-center">{{ $contract->plan->name }}</td>
                        <td class="text-center">R$ {{ number_format($contract->price, 2, ',', '.') }}</td>
                        <td class="text-center">
                            {{ $contract->start_date->format('d/m/Y') }}
                            -
                            {{ $contract->end_date?->format('d/m/Y') ?? '∞' }}
                        </td>
                        <td class="text-center">
                            @if($contract->isRunning())
                                <span class="text-green-600">Ativo</span>
                            @else
                                <span class="text-red-600">Inativo</span>
                            @endif
                        </td>
                        <td>  
                            <div class="flex items-center justify-center gap-1">  
                                <a href="{{route('vendas.contracts.edit',$contract)}}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>                            
                                
                                <button wire:click="generateInvoice({{ $contract->id }})"
                                        class="text-blue-500">
                                    Gerar Fatura
                                </button>

                                @if (auth()->user()->isSuperAdmin())
                                    <button type="button" 
                                            class="btn btn-xs bg-danger"
                                            wire:click="delete({{ $contract->id }})"
                                            title="Excluir"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif                              
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>                
            </table>
        </div> 

    </div>

</div>