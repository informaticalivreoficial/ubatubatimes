<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PrevisaoTempoService
{
    /**
     * Ubatuba/SP
     */
    private const LATITUDE  = -23.433;
    private const LONGITUDE = -45.083;

    /**
     * Weather codes Open-Meteo
     * https://open-meteo.com/en/docs
     */
    private const PREVISOES = [
        0  => 'Céu Limpo',
        1  => 'Principalmente Limpo',
        2  => 'Parcialmente Nublado',
        3  => 'Nublado',

        45 => 'Nevoeiro',
        48 => 'Nevoeiro com Gelo',

        51 => 'Garoa Leve',
        53 => 'Garoa Moderada',
        55 => 'Garoa Intensa',

        61 => 'Chuva Leve',
        63 => 'Chuva Moderada',
        65 => 'Chuva Forte',

        71 => 'Neve Leve',
        73 => 'Neve Moderada',
        75 => 'Neve Forte',

        80 => 'Pancadas de Chuva Leves',
        81 => 'Pancadas de Chuva',
        82 => 'Pancadas Fortes',

        95 => 'Tempestade',
        96 => 'Tempestade com Granizo',
        99 => 'Tempestade Forte com Granizo',
    ];

    private const IMAGENS = [
        0  => 'sol.png',
        1  => 'sol.png',
        2  => 'encoberto.png',
        3  => 'nublado.png',

        45 => 'encoberto.png',
        48 => 'encoberto.png',

        51 => 'chuva.png',
        53 => 'chuva.png',
        55 => 'chuva.png',

        61 => 'chuva.png',
        63 => 'chuva.png',
        65 => 'chuva.png',

        71 => 'encoberto.png',
        73 => 'encoberto.png',
        75 => 'encoberto.png',

        80 => 'sol-com-pancadas.png',
        81 => 'sol-com-pancadas.png',
        82 => 'tempestade.png',

        95 => 'tempestade.png',
        96 => 'tempestade.png',
        99 => 'tempestade.png',
    ];

    public function getBoletim(): ?array
    {
        try {

            $url = 'https://api.open-meteo.com/v1/forecast';

            $response = Http::timeout(10)
                ->get($url, [
                    'latitude'  => self::LATITUDE,
                    'longitude' => self::LONGITUDE,

                    'daily' => implode(',', [
                        'weathercode',
                        'temperature_2m_max',
                        'temperature_2m_min',
                        'uv_index_max',
                    ]),

                    'timezone' => 'America/Sao_Paulo',
                ]);

            if (!$response->successful()) {
                return null;
            }

            $data = $response->json();

            if (!isset($data['daily'])) {
                return null;
            }

            $responseFinal = [];

            foreach ($data['daily']['time'] as $index => $date) {

                $codigo = $data['daily']['weathercode'][$index];

                $responseFinal[] = [
                    'data' => Carbon::parse($date)
                        ->translatedFormat('l d/m/Y'),

                    'img' => self::IMAGENS[$codigo]
                        ?? 'sol.png',

                    'previsao' => self::PREVISOES[$codigo]
                        ?? 'Sem previsão',

                    'minima' => round(
                        $data['daily']['temperature_2m_min'][$index]
                    ),

                    'maxima' => round(
                        $data['daily']['temperature_2m_max'][$index]
                    ),

                    'iuv' => round(
                        $data['daily']['uv_index_max'][$index]
                    ),

                    'iuvcolor' => $this->getUvColor(
                        (int) round(
                            $data['daily']['uv_index_max'][$index]
                        )
                    ),
                ];
            }

            return $responseFinal;

        } catch (\Exception $e) {

            Log::error('Erro ao buscar previsão do tempo', [
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    private function getUvColor(int $valor): string
    {
        return match (true) {
            $valor <= 2 => 'color:#000;',
            $valor >= 3 && $valor <= 5 => 'color:#000;background:#fff336;',
            $valor >= 6 && $valor <= 7 => 'color:#000;background:#EDAC43;',
            $valor >= 8 && $valor <= 10 => 'color:#fff;background:#D92927;',
            $valor >= 11 => 'color:#fff;background:#C72BB2;',
            default => 'color:#000;',
        };
    }
}