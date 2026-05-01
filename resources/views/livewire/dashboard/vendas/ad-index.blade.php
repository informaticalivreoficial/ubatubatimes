<div>
    @section('title', $title) 
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-search mr-2"></i> Anúncios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">                    
                        <li class="breadcrumb-item"><a href="{{route('admin')}}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Anúncios</li>
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
                            <input type="text" wire:model.live="search" class="form-control float-right" placeholder="Pesquisar">               
                        </div>
                      </div>
                </div>
                <div class="col-12 col-sm-6 my-2 text-right">
                    <a href="{{route('vendas.ads.create')}}" class="btn btn-sm btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Novo</a>
                </div>
            </div>
        </div> 

        <div class="card-body">
            <table class="table table-bordered table-striped projects">
                <thead>
                    <tr>
                        <th wire:click="sortBy('alias_name')" style="cursor:pointer">
                            Empresa 
                            <i class="fas fa-caret-{{ $sortField === 'alias_name' ? ($sortDirection === 'asc' ? 'up' : 'down') : 'down' }}"></i>
                        </th>
                        <th>Plano</th>
                        <th class="text-center">Preview</th>
                        <th class="text-center">Período</th>
                        <th class="text-center">Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ads as $ad)                   
                    <tr style="{{ ($ad->isActive() ? '' : 'background: #fffed8 !important;')  }}">                            
                        <td>{{ $ad->company->alias_name }}</td>
                        <td class="text-center">{{ $ad->plan->name }}</td>
                        <td class="text-center">
                            <img src="{{ asset('storage/' . $ad->image) }}" class="h-12">
                        </td>
                        <td class="text-center">
                            {{ $ad->start_date->format('d/m/Y') }}
                            -
                            {{ $ad->end_date?->format('d/m/Y') ?? '∞' }}
                        </td>
                        <td class="text-center">
                            @if($ad->isActive())
                                <span class="text-green-600">Ativo</span>
                            @else
                                <span class="text-red-600">Inativo</span>
                            @endif
                        </td>
                        <td>  
                            <div class="flex items-center justify-center gap-1">  
                                <a href="{{route('vendas.ads.edit', $ad )}}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>                            
                                
                                @if (auth()->user()->isSuperAdmin())
                                    <button type="button" 
                                            class="btn btn-xs bg-danger"
                                            wire:click="delete({{ $ad->id }})"
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
