<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PagHiperService
{
    public function createBoleto($invoice, $customer)
    {
        $payload = [
            'apiKey' => config('services.paghiper.api_key'),
            'token' => config('services.paghiper.token'),

            'order_id' => (string) $invoice->id,

            'payer_email' => $customer->email,
            'payer_name' => $customer->alias_name,
            'payer_cpf_cnpj' => '00000000191', // 👈 usa esse pra teste

            'days_due_date' => 3,
            'type_bank_slip' => 'boletoA4',

            'notification_url' => url('/api/webhook/paghiper'),

            'items' => [
                [
                    'description' => $invoice->description ?? 'Anúncio',
                    'quantity' => '1',
                    'item_id' => '1',
                    'price_cents' => (int) ($invoice->amount * 100),
                ]
            ],
        ];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://api.paghiper.com/transaction/create/', $payload);

        $data = $response->json();        

        if (
            isset($data['create_request']['result']) &&
            $data['create_request']['result'] === 'success'
        ) {
            return [
                'transaction_id' => $data['create_request']['transaction_id'],
                'boleto_url' => $data['create_request']['bank_slip']['url_slip'] ?? null,
            ];
        }

        throw new \Exception($data['create_request']['response_message'] ?? 'Erro ao gerar boleto');
    }
}