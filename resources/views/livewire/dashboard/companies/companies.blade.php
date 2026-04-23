<div>    
    @section('title', $title) 
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-search mr-2"></i> Empresas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">                    
                        <li class="breadcrumb-item"><a href="{{route('admin')}}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Empresas</li>
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
            @if(!empty($companies) && $companies->count() > 0)
                <div class="overflow-x-auto" x-data="{ showModal: false, imageUrl: '' }">
                    <table class="table table-bordered table-striped projects">
                        <thead>
                            <tr>
                                <th>Logomarca</th>
                                <th wire:click="sortBy('alias_name')">Nome Fantasia <i class="expandable-table-caret fas fa-caret-down fa-fw"></i></th>
                                <th class="text-center">Faturas</th>
                                <th class="text-center">Responsável</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($companies as $company)                    
                            <tr style="{{ ($company->status == true ? '' : 'background: #fffed8 !important;')  }}">                            
                                <td>
                                    <img 
                                        src="{{$company->getlogo()}}" 
                                        alt="{{$company->alias_name}}" 
                                        title="{{$company->alias_name}}"
                                        class="w-12 mx-auto cursor-pointer rounded-lg hover:scale-105 transition-transform"
                                        @click="showModal = true; imageUrl = '{{ addslashes(url($company->getlogo())) }}'"
                                    />
                                </td>
                                <td>{{$company->alias_name}}</td>
                                <td class="text-center">{{--  --}}</td>
                                <td class="text-center">{{$company->responsable_name}}</td>
                                <td>  
                                    <div class="flex items-center justify-center gap-1">                              
                                        <x-forms.switch-toggle
                                            wire:key="safe-switch-{{ $company->id }}"
                                            wire:click="toggleStatus({{ $company->id }})"
                                            :checked="$company->status"
                                            size="sm"
                                            color="green"
                                        />   
                                        <a 
                                            target="_blank" 
                                            href="{{ route('web.guiaEmpresa', [ 'slug' => $company->slug]) }}" 
                                            class="btn btn-xs bg-info" 
                                            title="Visualizar">
                                            <i class="fas fa-search"></i>
                                        </a>                                    
                                          
                                        </button>                                  
                                        <a href="{{route('companies.edit',['company' => $company->id])}}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                        @if (auth()->user()->isSuperAdmin())
                                            <button type="button" 
                                                    class="btn btn-xs bg-danger"
                                                    wire:click="setDeleteId({{ $company->id }})"
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
                    <!-- Modal de imagem -->
                    <div x-show="showModal" x-cloak
                        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-[9999]"
                        x-transition>
                        <div class="relative">
                            <img :src="imageUrl" class="max-w-[70vw] max-h-[70vh] object-contain mx-auto rounded shadow-lg">
                            <button type="button" @click="showModal = false"
                                    class="absolute top-2 right-2 text-white text-xl bg-black bg-opacity-50 rounded-full px-2 py-1 hover:bg-opacity-75 transition">
                                ✕
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="row mb-4">
                    <div class="col-12">                                                        
                        <div class="alert alert-info p-3">
                            Não foram encontrados registros!
                        </div>                                                        
                    </div>
                </div>
            @endif
        </div>
        <div class="card-footer clearfix">  
            {{ $companies->links() }}  
        </div>
    </div>  

</div>

<script>    
    
</script>