<div>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-industry mr-2"></i> {{ $ad ? 'Editar' : 'Cadastrar' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vendas.ads.index') }}">Anúncios</a></li>
                        <li class="breadcrumb-item active">{{ $ad ? 'Editar' : 'Cadastrar' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save" autocomplete="off">
        <div class="card card-teal card-outline">            
            <div class="card-body"> 
                <div class="row">

                    {{-- Empresa --}}
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <div class="form-group">
                            <label class="labelforms"><b>Empresa</b></label>
                            <select class="form-control @error('company_id') is-invalid @enderror" wire:model.live="company_id">
                                <option value="">Selecione uma empresa</option>
                                @foreach($companies as $id => $alias_name)
                                    <option value="{{ $id }}">{{ $alias_name }}</option>
                                @endforeach
                            </select>
                            @error('company_id') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Plano --}}
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <div class="form-group">
                            <label class="labelforms"><b>Plano</b></label>
                            <select class="form-control @error('plan_id') is-invalid @enderror" wire:model="plan_id">
                                <option value="">Selecione um plano</option>
                                @foreach($plans as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('plan_id') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Contrato (filtrado pela empresa) --}}
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <div class="form-group">
                            <label class="labelforms"><b>Contrato</b></label>
                            <select class="form-control @error('ad_contract_id') is-invalid @enderror" wire:model="ad_contract_id" @disabled(!$company_id)>
                                <option value="">
                                    {{ $company_id ? 'Selecione um contrato' : 'Selecione uma empresa primeiro' }}
                                </option>
                                @foreach($contracts as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('ad_contract_id') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                </div>
                <div class="row">

                    {{-- Título --}}
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <div class="form-group">
                            <label class="labelforms"><b>Título</b></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" wire:model="title">
                            @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Link --}}
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <div class="form-group">
                            <label class="labelforms"><b>Link</b></label>
                            <input type="url" class="form-control @error('link') is-invalid @enderror" wire:model="link">
                            @error('link') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Ativo --}}
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <div class="form-group">
                            <label class="labelforms d-block"><b>Ativo</b></label>
                            <div class="mt-2">
                                <input type="checkbox" wire:model="active"> 
                                <span class="ml-1">Anúncio ativo</span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">

                    {{-- Início --}}
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <div class="form-group">
                            <label class="labelforms"><b>Início</b></label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" wire:model="start_date">
                            @error('start_date') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Fim --}}
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <div class="form-group">
                            <label class="labelforms"><b>Fim</b></label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" wire:model="end_date">
                            @error('end_date') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                </div>
                <div class="row">                   

                    {{-- Imagem --}}
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Imagem                               
                            </label>

                            <div class="relative group w-full max-w-[260px]">
                                <input 
                                    type="file"
                                    id="image"
                                    wire:model="image"
                                    accept="image/png,image/jpeg,image/webp"
                                    class="hidden"
                                >

                                <label for="image" class="cursor-pointer block">
                                    <div class="relative rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                                        
                                        <img
                                            src="{{ $this->imageUrl }}"
                                            class="w-full h-[180px] object-contain p-3 transition group-hover:scale-105"
                                        >

                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                            <span class="text-white text-sm font-medium">
                                                Alterar imagem
                                            </span>
                                        </div>

                                        <div wire:loading wire:target="image"
                                            class="absolute inset-0 bg-white/70 flex items-center justify-center">
                                            <span class="text-sm text-gray-600">Enviando...</span>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            @error('image')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="row text-right">
                    <div class="col-12 pb-4 mt-3">
                        <button type="submit" class="btn btn-lg btn-success p-3">
                            <i class="nav-icon fas fa-check mr-2"></i>{{ $ad ? 'Atualizar Agora' : 'Cadastrar Agora' }}
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>