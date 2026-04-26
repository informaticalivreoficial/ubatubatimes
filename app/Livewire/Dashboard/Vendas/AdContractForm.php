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

    public function mount(AdContract $contract = null)
    {
        if ($contract && $contract->exists) {
            $this->contract = $contract;
            $this->fill($contract->toArray());
        }
    }

    public function save()
    {
        $data = $this->validate([
            'company_id' => 'required',
            'plan_id' => 'required',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'auto_renew' => 'boolean',
            'active' => 'boolean',
        ]);

        AdContract::updateOrCreate(
            ['id' => $this->contract->id ?? null],
            $data
        );

        session()->flash('success', 'Contrato salvo!');

        return redirect()->route('contracts.index');
    }

    public function render()
    {
        return view('livewire.dashboard.vendas.ad-contract-form', [
            'companies' => Company::pluck('alias_name', 'id'),
            'plans' => Plan::pluck('name', 'id'),
        ]);
    }
}
