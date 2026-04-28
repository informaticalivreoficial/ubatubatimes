<?php

namespace App\Livewire\Dashboard\Vendas;

use App\Models\AdContract;
use App\Models\Invoice;
use App\Traits\WithToastr;
use App\Services\PagHiperService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class InvoiceIndex extends Component
{
    use WithToastr;

    public function generateBoleto($id)
    {
        $invoice = Invoice::findOrFail($id);

        // 🔒 Evita duplicidade
        if ($invoice->external_id) {
            $this->toastError('Boleto já foi gerado.');
            return;
        }

        try {
            $service = app(PagHiperService::class);

            $result = $service->createBoleto($invoice, $invoice->company);

            $invoice->update([
                'external_id' => $result['transaction_id'],
                'boleto_url' => $result['boleto_url'],
                'boleto_pdf' => $result['boleto_pdf'],
                'linha_digitavel' => $result['linha_digitavel'],
            ]);

            if (!$result || empty($result['transaction_id'])) {
                throw new \Exception('Resposta inválida do PagHiper');
            }

            $invoice->update([
                'external_id' => $result['transaction_id'],
                'boleto_url' => $result['boleto_url'] ?? null,
                'payment_method' => 'boleto',
            ]);

            $this->toastSuccess('Boleto gerado com sucesso!');

        } catch (\Throwable $e) {
            $this->toastError('Erro ao gerar boleto. Tente novamente.');
        }
    }

    public function markAsPaid($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->markAsPaid();

        $this->toastSuccess('Marcado como pago!');
    }

    public function cancel($id)
    {
        $invoice = Invoice::findOrFail($id);

        $invoice->update([
            'status' => 'canceled'
        ]);

        $this->toastError('Boleto cancelado!');
    }

    public function render()
    {
        $title = 'Lista de Faturas';
        $invoices = Invoice::with(['company', 'contract'])->latest()->get();
        
        return view('livewire.dashboard.vendas.invoice-index', compact('invoices'))->with('title', $title);
    }
}
