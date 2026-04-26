<?php

namespace App\Livewire\Dashboard\Vendas;

use App\Models\AdContract;
use Livewire\Component;

class AdContractIndex extends Component
{
    public function delete($id)
    {
        AdContract::findOrFail($id)->delete();
    }

    public function generateInvoice($id)
    {
        $contract = AdContract::findOrFail($id);

        $invoice = $contract->generateInvoice();

        // aqui você pode já integrar com PagHiper depois

        session()->flash('success', 'Fatura gerada!');
    }

    public function render()
    {
        $contracts = AdContract::with(['company', 'plan'])->latest()->get();
        return view('livewire.dashboard.vendas.ad-contract-index', compact('contracts'));
    }
}
