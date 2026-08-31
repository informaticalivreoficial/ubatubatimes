<div>
    @section('title', $contract ? 'Editar Contrato' : 'Novo Contrato')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-file-signature mr-2"></i> {{ $contract ? 'Editar Contrato' : 'Novo Contrato' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vendas.contracts.index') }}">Contratos</a></li>
                        <li class="breadcrumb-item active">{{ $contract ? 'Editar' : 'Novo' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <form wire:submit.prevent="save" autocomplete="off">
            <div class="card-body text-muted">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="labelforms"><b>*Empresa</b></label>
                            <select class="form-control @error('company_id') is-invalid @enderror" wire:model="company_id">
                                <option value="">-- Selecione uma empresa --</option>
                                @foreach($companies as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="labelforms"><b>*Plano</b></label>
                            <select class="form-control @error('plan_id') is-invalid @enderror" wire:model="plan_id">
                                <option value="">-- Selecione um plano --</option>
                                @foreach($plans as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('plan_id')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label class="labelforms"><b>*Valor</b></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">R$</span>
                                </div>
                                <input
                                    type="text"
                                    id="price"
                                    wire:model="price"
                                    @disabled($free)
                                    class="form-control @error('price') is-invalid @enderror {{ $free ? 'bg-light' : '' }}"
                                    placeholder="0,00"
                                >
                            </div>
                            @error('price')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label class="labelforms"><b>*Data de Início</b></label>
                            <input
                                type="text"
                                id="start_date"
                                wire:model="start_date"
                                class="form-control @error('start_date') is-invalid @enderror"
                                placeholder="dd/mm/aaaa"
                            >
                            @error('start_date')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label class="labelforms"><b>Data de Término</b></label>
                            <input
                                type="text"
                                id="end_date"
                                wire:model="end_date"
                                class="form-control @error('end_date') is-invalid @enderror"
                                placeholder="dd/mm/aaaa"
                            >
                            @error('end_date')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="free" wire:model.live="free">
                                <label class="custom-control-label" for="free">Contrato Free (sem cobrança)</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="auto_renew" wire:model="auto_renew">
                                <label class="custom-control-label" for="auto_renew">Renovação automática</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="active" wire:model="active">
                                <label class="custom-control-label" for="active">Ativo</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <a href="{{ route('vendas.contracts.index') }}" class="btn btn-default">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="nav-icon fas fa-check mr-2"></i>{{ $contract ? 'Atualizar Contrato' : 'Salvar Contrato' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    (function () {
        let fpStart = null;
        let fpEnd = null;
        let priceMask = null;

        function initDatePicker(selector, instance) {
            const input = document.getElementById(selector);
            if (!input) return null;

            if (instance) {
                instance.destroy();
            }

            return flatpickr(input, {
                dateFormat: 'd/m/Y',
                allowInput: true,
                locale: window.FlatpickrPortuguese || 'pt',
                defaultDate: input.value || null,
                onChange: function (selectedDates, dateStr, inst) {
                    input.value = selectedDates.length
                        ? inst.formatDate(selectedDates[0], 'd/m/Y')
                        : '';
                    input.dispatchEvent(new Event('input'));
                }
            });
        }

        function initPriceMask() {
            const input = document.getElementById('price');
            if (!input) return;

            if (priceMask) {
                priceMask.destroy();
            }

            priceMask = IMask(input, {
                mask: Number,
                scale: 2,
                signed: false,
                thousandsSeparator: '.',
                padFractionalZeros: true,
                normalizeZeros: true,
                radix: ',',
                mapToRadix: ['.'],
                min: 0,
                max: 999999999
            });

            // Sincroniza o valor mascarado com o Livewire
            priceMask.on('accept', function () {
                input.dispatchEvent(new Event('input'));
            });
        }

        function init() {
            fpStart = initDatePicker('start_date', fpStart);
            fpEnd = initDatePicker('end_date', fpEnd);
            initPriceMask();
        }

        document.addEventListener('livewire:load', init);
        document.addEventListener('livewire:navigated', init);
    })();
</script>
