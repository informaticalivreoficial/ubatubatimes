<?php

namespace App\Livewire\Dashboard\Vendas;

use App\Models\AdContract;
use App\Models\Invoice;
use Livewire\Component;
use PagHiperService;

class InvoiceIndex extends Component
{
    public function markAsPaid($id)
    {
        $invoice = Invoice::findOrFail($id);

        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    public function generateInvoice($contractId)
    {
        $contract = AdContract::findOrFail($contractId);

        $invoice = Invoice::create([
            'company_id' => $contract->company_id,
            'ad_contract_id' => $contract->id,
            'amount' => $contract->price,
            'due_date' => now()->addDays(3),
        ]);

        app(PagHiperService::class)
            ->createBoleto($invoice, $contract->company);
    }

    public function render()
    {
        return view('livewire.dashboard.vendas.invoice-index');
    }
}
