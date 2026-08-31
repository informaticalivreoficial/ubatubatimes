<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PagHiperService
{
    private const ENDPOINT_CREATE = 'https://api.paghiper.com/transaction/create/';

    public function createBoleto($invoice, $customer)
    {
        $document = $this->payerDocument($customer);

        $payload = [
            'apiKey' => config('services.paghiper.api_key'),
            'token' => config('services.paghiper.token'),

            'order_id' => (string) $invoice->id,

            'payer_email' => $customer->email,
            'payer_name' => $customer->alias_name,
            'payer_cpf_cnpj' => $document,

            'days_due_date' => $this->daysUntilDue($invoice),
            'type_bank_slip' => 'boletoA4',

            'notification_url' => url('/api/webhook/paghiper'),

            'items' => [
                [
                    'description' => $this->description($invoice),
                    'quantity' => '1',
                    'item_id' => '1',
                    'price_cents' => (int) round($invoice->amount * 100),
                ]
            ],
        ];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->timeout(20)
            ->post(self::ENDPOINT_CREATE, $payload);

        if ($response->failed()) {
            Log::error('PagHiper: falha HTTP ao gerar boleto', [
                'invoice_id' => $invoice->id,
                'status'     => $response->status(),
                'body'       => $response->body(),
            ]);

            throw new \Exception('Falha na comunicação com o PagHiper (HTTP ' . $response->status() . ')');
        }

        $data = $response->json() ?? [];
        $create = $data['create_request'] ?? [];

        if (($create['result'] ?? null) === 'success') {
            $slip = $create['bank_slip'] ?? [];

            return [
                'transaction_id'  => $create['transaction_id'] ?? null,
                'boleto_url'      => $slip['url_slip'] ?? null,
                'boleto_pdf'      => $slip['url_slip_pdf'] ?? null,
                'linha_digitavel' => $slip['digitable_line'] ?? null,
            ];
        }

        Log::error('PagHiper: falha ao gerar boleto', [
            'invoice_id' => $invoice->id,
            'response'   => $data,
        ]);

        throw new \Exception($create['response_message'] ?? 'Erro ao gerar boleto');
    }

    /**
     * CPF/CNPJ do pagador: usa o documento real da empresa (apenas dígitos).
     * Fallback para CPF de teste quando não houver documento cadastrado.
     */
    private function payerDocument($customer): string
    {
        $document = $customer->document_company
            ?? $customer->responsable_cpf
            ?? null;

        $document = preg_replace('/\D/', '', (string) $document);

        return $document !== '' ? $document : '00000000191';
    }

    /**
     * Dias até o vencimento a partir do due_date da fatura (mínimo 1).
     */
    private function daysUntilDue($invoice): int
    {
        if (empty($invoice->due_date)) {
            return 3;
        }

        $days = now()->startOfDay()->diffInDays($invoice->due_date->copy()->startOfDay(), false);

        return max(1, (int) $days);
    }

    private function description($invoice): string
    {
        $plan = $invoice->contract?->plan?->name;

        return $plan ? "Anúncio - {$plan}" : 'Anúncio';
    }
}
