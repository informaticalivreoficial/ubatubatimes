<?php

use Illuminate\Support\Facades\Http;

class PagHiperService
{
    public function createBoleto($invoice, $customer)
    {
        $response = Http::asForm()->post('https://pix.paghiper.com/invoice/create/', [
            'apiKey' => config('services.paghiper.api_key'),
            'token' => config('services.paghiper.token'),

            'order_id' => $invoice->id,
            'payer_email' => $customer->email,
            'payer_name' => $customer->name,

            'payer_cpf_cnpj' => $customer->document ?? '00000000000',

            'days_due_date' => 3,
            'value_cents' => $invoice->amount * 100,

            'notification_url' => route('webhook.paghiper'),
        ]);

        $data = $response->json();

        if (!empty($data['create_request']['transaction_id'])) {
            return [
                'transaction_id' => $data['create_request']['transaction_id'],
                'boleto_url' => $data['create_request']['bank_slip']['url_slip'],
            ];
        }

        throw new \Exception('Erro ao gerar boleto PagHiper');
    }
}