<?php

namespace App\Livewire\Dashboard\Vendas;

use App\Models\AdContract;
use App\Models\Company;
use App\Models\Plan;
use Livewire\Component;

class AdContractForm extends Component
{
    public $contract;

    public $company_id;
    public $plan_id;
    public $price;
    public $start_date;
    public $end_date;
    public $auto_renew = true;
    public $active = true;
    public $free   = false;

    public function mount(AdContract $contract = null)
    {
        if ($contract && $contract->exists) {
            $this->contract = $contract;
            $this->fill($contract->toArray());
        }
    }

    public function updatedFree($value)
    {
        // Se marcar free, zera o preço automaticamente
        if ($value) {
            $this->price = 0;
        }
    }

    public function save(): void
    {
        $data = $this->validate([
            'company_id' => 'required',
            'plan_id'    => 'required',
            'price'      => 'required_if:free,false|numeric|min:0',
            'start_date' => 'required|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'auto_renew' => 'boolean',
            'active'     => 'boolean',
            'free'       => 'boolean',
        ]);

        $isNew = !($this->contract->id ?? null);

        $contract = AdContract::updateOrCreate(
            ['id' => $this->contract->id ?? null],
            $data
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

    public function render()
    {
        return view('livewire.dashboard.vendas.ad-contract-form', [
            'companies' => Company::pluck('alias_name', 'id'),
            'plans' => Plan::pluck('name', 'id'),
        ]);
    }
}
