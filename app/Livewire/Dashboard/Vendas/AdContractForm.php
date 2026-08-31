<?php

namespace App\Livewire\Dashboard\Vendas;

use App\Models\AdContract;
use App\Models\Company;
use App\Models\Plan;
use Carbon\Carbon;
use Livewire\Component;

class AdContractForm extends Component
{
    public $contract;

    public $company_id;
    public $plan_id;
    public $price;
    public $start_date;
    public $end_date;
    public bool $auto_renew = true;
    public bool $active = true;
    public bool $free   = false;

    public function mount(AdContract $contract = null)
    {
        if ($contract && $contract->exists) {
            $this->contract   = $contract;
            $this->company_id = $contract->company_id;
            $this->plan_id    = $contract->plan_id;
            $this->auto_renew = (bool) $contract->auto_renew;
            $this->active     = (bool) $contract->active;
            $this->free       = (bool) $contract->free;

            // Formata para exibição nos inputs (d/m/Y e moeda pt-BR)
            $this->start_date = $contract->start_date?->format('d/m/Y');
            $this->end_date   = $contract->end_date?->format('d/m/Y');
            $this->price      = $contract->price !== null
                ? number_format((float) $contract->price, 2, ',', '.')
                : null;
        }
    }

    public function updatedFree($value)
    {
        // Se marcar free, zera o preço automaticamente
        if ($value) {
            $this->price = '0,00';
        }
    }

    public function save(): void
    {
        $data = $this->validate([
            'company_id' => 'required',
            'plan_id'    => 'required',
            'price'      => 'required_if:free,false',
            'start_date' => 'required|date_format:d/m/Y',
            'end_date'   => 'nullable|date_format:d/m/Y',
            'auto_renew' => 'boolean',
            'active'     => 'boolean',
            'free'       => 'boolean',
        ], [
            'company_id.required'      => 'Selecione uma empresa.',
            'plan_id.required'         => 'Selecione um plano.',
            'price.required_if'        => 'Informe o valor do contrato.',
            'start_date.required'      => 'Informe a data de início.',
            'start_date.date_format'   => 'A data de início deve estar no formato dd/mm/aaaa.',
            'end_date.date_format'     => 'A data de término deve estar no formato dd/mm/aaaa.',
        ]);

        $startDate = Carbon::createFromFormat('d/m/Y', $data['start_date']);
        $endDate   = !empty($data['end_date'])
            ? Carbon::createFromFormat('d/m/Y', $data['end_date'])
            : null;

        if ($endDate && $endDate->lt($startDate)) {
            $this->addError('end_date', 'A data de término deve ser igual ou posterior à data de início.');

            return;
        }

        $isNew = !($this->contract->id ?? null);

        $contract = AdContract::updateOrCreate(
            ['id' => $this->contract->id ?? null],
            [
                'company_id' => $data['company_id'],
                'plan_id'    => $data['plan_id'],
                'price'      => $this->normalizePrice($data['price']),
                'start_date' => $startDate->format('Y-m-d'),
                'end_date'   => $endDate?->format('Y-m-d'),
                'auto_renew' => $this->auto_renew,
                'active'     => $this->active,
                'free'       => $this->free,
            ]
        );

        // Gera fatura apenas na criação e se não for free
        if ($isNew && !$contract->free) {
            $contract->generateInvoice();
        }

        $this->dispatch('swal:success', [
            'title'             => 'Sucesso!',
            'text'              => $isNew ? 'Contrato cadastrado com sucesso!' : 'Contrato atualizado com sucesso!',
            'timer'             => 2000,
            'showConfirmButton' => false,
        ]);

        redirect()->route('vendas.contracts.index');
    }

    /**
     * Converte a máscara pt-BR ("1.234,56") para float (1234.56).
     */
    private function normalizePrice($value): float
    {
        $value = (string) $value;
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        return (float) $value;
    }

    public function render()
    {
        return view('livewire.dashboard.vendas.ad-contract-form', [
            'companies' => Company::pluck('alias_name', 'id'),
            'plans' => Plan::pluck('name', 'id'),
        ]);
    }
}
