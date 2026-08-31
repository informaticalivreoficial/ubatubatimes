<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PagHiperWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Valida API Key
        if ($request->apiKey !== config('services.paghiper.api_key')) {
            Log::warning('PagHiper webhook: API key inválida');
            abort(403);
        }

        // 2. Busca fatura pela transaction_id
        $transactionId = $request->transaction_id ?? $request->get('transaction_id');

        if (empty($transactionId)) {
            Log::warning('PagHiper webhook: transaction_id ausente');
            abort(422);
        }

        $invoice = Invoice::where('external_id', $transactionId)->first();

        if (!$invoice) {
            Log::warning('PagHiper webhook: fatura não encontrada', [
                'transaction_id' => $transactionId,
            ]);

            return response()->json(['ok' => false, 'message' => 'invoice not found'], 404);
        }

        // 3. Processa status
        $status = $request->status ?? $request->get('status');

        Log::info('PagHiper webhook: recebido', [
            'invoice_id'     => $invoice->id,
            'transaction_id' => $transactionId,
            'status'         => $status,
        ]);

        match ($status) {
            'paid'     => $this->handlePaid($invoice),
            'expired'  => $invoice->markAsOverdue(),
            'canceled' => $invoice->update(['status' => 'canceled']),
            default    => null,
        };

        return response()->json(['ok' => true]);
    }

    private function handlePaid(Invoice $invoice): void
    {
        $invoice->markAsPaid();

        Log::info('PagHiper webhook: fatura paga', [
            'invoice_id' => $invoice->id,
        ]);
    }
}
