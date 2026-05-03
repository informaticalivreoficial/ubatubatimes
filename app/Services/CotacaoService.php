<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CotacaoService
{
    public function getDolar(): ?array
    {
        return Cache::remember('cotacao_dolar', 300, function () {
            try {
                $response = Http::get('https://economia.awesomeapi.com.br/json/USD-BRL/1');

                if (!$response->ok()) return null;

                $data = $response->json();
                $item = end($data);

                $pct = (float) $item['pctChange'];

                return [
                    'name'   => $item['name'],
                    'ask'    => number_format($item['ask'], 3, ',', ''),
                    'pct'    => number_format($pct, 2, ',', ''),
                    'sinal'  => $pct > 0 ? '+' : '',
                    'cor'    => $pct < 0 ? 'pos' : ($pct > 0 ? 'neg' : 'neutro'),
                ];

            } catch (\Exception $e) {
                return null;
            }
        });
    }
}