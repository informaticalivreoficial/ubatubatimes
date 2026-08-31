<div>
    @section('title', 'Sincronizar Crawlers')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-sync-alt mr-2"></i> Sincronizar Crawlers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin')}}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{route('posts.index')}}">Posts</a></li>
                        <li class="breadcrumb-item active">Crawlers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">
                            <i class="fas fa-robot mr-2"></i> Fontes de Notícias
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">Selecione os crawlers que deseja sincronizar e clique em "Sincronizar".</p>

                        <div class="mb-3">
                            <button type="button" class="btn btn-sm btn-outline-secondary mr-2" wire:click="selectAll">
                                <i class="fas fa-check-double mr-1"></i> Selecionar Todos
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="deselectAll">
                                <i class="fas fa-times mr-1"></i> Desmarcar Todos
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="50" class="text-center">
                                            <input type="checkbox" id="checkAll"
                                                @change="
                                                    if ($el.checked) {
                                                        $wire.selectAll()
                                                    } else {
                                                        $wire.deselectAll()
                                                    }
                                                ">
                                        </th>
                                        <th>Crawler</th>
                                        <th>Descrição</th>
                                        <th width="120" class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($this->crawlers as $crawler)
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox"
                                                    value="{{ $crawler['id'] }}"
                                                    wire:model.live="selected"
                                                    {{ in_array($crawler['id'], $selected) ? 'checked' : '' }}>
                                            </td>
                                            <td class="font-weight-bold">
                                                <i class="fas fa-angle-right text-primary mr-2"></i>
                                                {{ $crawler['name'] }}
                                            </td>
                                            <td class="text-muted">{{ $crawler['description'] }}</td>
                                            <td class="text-center">
                                                @if(in_array($crawler['id'], $selected))
                                                    <span class="badge badge-primary">
                                                        <i class="fas fa-check mr-1"></i> Selecionado
                                                    </span>
                                                @else
                                                    <span class="badge badge-secondary">Aguardando</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button type="button"
                                class="btn btn-success btn-lg"
                                wire:click="sync"
                                wire:loading.attr="disabled"
                                wire:target="sync">
                                <span wire:loading.remove wire:target="sync">
                                    <i class="fas fa-sync-alt mr-2"></i> Sincronizar Selecionados
                                </span>
                                <span wire:loading wire:target="sync">
                                    <i class="fas fa-spinner fa-spin mr-2"></i> Enviando para fila...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">
                            <i class="fas fa-info-circle mr-2"></i> Informações
                        </h3>
                    </div>
                    <div class="card-body">
                        <h5>Como funciona?</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-arrow-right text-primary mr-2"></i>
                                Os crawlers são enviados para a <strong>fila de processamento</strong> (queue)
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-arrow-right text-primary mr-2"></i>
                                Cada crawler busca notícias novas no site fonte
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-arrow-right text-primary mr-2"></i>
                                Notícias duplicadas são automaticamente ignoradas
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-arrow-right text-primary mr-2"></i>
                                As imagens são baixadas e convertidas para WebP
                            </li>
                        </ul>

                        <hr>

                        <h5>Crawlers disponíveis</h5>
                        <ul class="list-unstyled">
                            <li class="mb-1">
                                <span class="badge badge-info">7</span> fontes configuradas
                            </li>
                            <li class="mb-1">
                                <i class="fas fa-clock text-muted mr-1"></i> Timeout: 120s por crawler
                            </li>
                            <li class="mb-1">
                                <i class="fas fa-redo text-muted mr-1"></i> 1 tentativa por execução
                            </li>
                        </ul>
                    </div>
                </div>

                @if(!empty($results))
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-check-circle mr-2"></i> Resultado
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @foreach($results as $result)
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-paper-plane text-success mr-2"></i>
                                        <span>{{ $result['name'] }}</span>
                                        <span class="badge badge-success ml-auto">Enviado</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
