<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class OndasService
{
    public function get()
    {
        $marine = Http::get('https://marine-api.open-meteo.com/v1/marine', [
            'latitude'  => -23.433,
            'longitude' => -45.083,
            'hourly'    => 'wave_height,wave_direction',
            'timezone'  => 'America/Sao_Paulo'
        ])->json();

        $weather = Http::get('https://api.open-meteo.com/v1/forecast', [
            'latitude'  => -23.433,
            'longitude' => -45.083,
            'hourly'    => 'wind_speed_10m,wind_direction_10m',
            'timezone'  => 'America/Sao_Paulo'
        ])->json();

        $manha = $this->formatPeriodo($marine, $weather, 9);
        $tarde = $this->formatPeriodo($marine, $weather, 15);

        return [
            'manha'  => $manha,
            'tarde'  => $tarde,
            'resumo' => [
                'geral' => $this->gerarResumo($marine, $weather),
                'manha' => $this->resumo($manha),
                'tarde' => $this->resumo($tarde),
            ],
            'mares' => $this->getMares(),
        ];
    }

    private function formatPeriodo($marine, $weather, $hour)
    {
        $index = collect($marine['hourly']['time'])
            ->search(fn($time) => date('H', strtotime($time)) == $hour);

        if ($index === false) return null;

        $altura = $marine['hourly']['wave_height'][$index];

        $ventoGraus = $weather['hourly']['wind_direction_10m'][$index] ?? null;
        $ondaGraus  = $marine['hourly']['wave_direction'][$index] ?? null;
        
        $icon = $this->getIcon($altura);

        return [
            'altura' => $this->formatAltura($altura),
            //'img' => $this->getIcon($altura),
             'img' => $icon['url'],
             'img_path' => $icon['path'],

            'vento' => $weather['hourly']['wind_speed_10m'][$index] ?? null,
            'vento_dir' => $this->grausParaDirecao($ventoGraus),
            'vento_dir_short' => $this->grausParaDirecao($ventoGraus, false),

            'direcao_onda' => $this->grausParaDirecao($ondaGraus),
            'direcao_onda_short' => $this->grausParaDirecao($ondaGraus, false),
        ];
    }

    private function getMares()
    {
        return Cache::remember('mare_ubatuba', now()->addHours(6), function () {

            $key = config('services.tide.key');

            //dd($key);

            if (!$key) {
                return [];
            }

            try {
                $response = Http::withHeaders([
                    'X-API-Key' => $key,
                ])->get('https://tidecheck.com/api/stations/nearest', [
                    'lat' => -23.433,
                    'lng' => -45.083,
                ]);                

                $station = $response->json();   
                
                $nearest = $station[0] ?? null;

                if (empty($nearest['id'])) {
                    return [];
                }

                // 👇 segunda chamada usando o id da estação
                $tides = Http::withHeaders([
                    'X-API-Key' => $key,
                ])->get("https://tidecheck.com/api/station/{$nearest['id']}/tides", [
                    'days' => 1,
                ]);

                //dd($tides->status(), $tides->json());

                if (!$tides->ok()) {
                    return [];
                }

                return collect($tides->json()['extremes'] ?? [])
                ->map(fn($item) => [
                    'tipo'   => ($item['type'] ?? '') === 'High' ? 'Cheia' : 'Seca',
                    'hora'   => isset($item['time']) ? date('H:i', strtotime($item['time'])) : null,
                    'altura' => isset($item['height']) ? round($item['height'], 2) : null,
                ])
                ->take(6)
                ->values()
                ->toArray();

            } catch (\Throwable $e) {
                return [];
            }
        });
    }

    private function gerarResumo($marine, $weather)
    {
        $altura = $marine['hourly']['wave_height'][9] ?? 0;
        $vento = $weather['hourly']['wind_speed_10m'][9] ?? 0;

        if ($altura < 0.7) {
            return "Ondas pequenas, pouco consistentes. Condições fracas para surf.";
        }

        if ($altura < 1.5 && $vento < 10) {
            return "Ondas médias com vento fraco. Condições razoáveis.";
        }

        if ($altura >= 1.5 && $vento < 10) {
            return "Boas ondas e vento favorável. Ótimas condições para surf.";
        }

        return "Ondas com vento forte. Condições irregulares.";
    }

    private function formatAltura($altura)
    {
        if ($altura < 0.5) return 'Flat';
        if ($altura < 1.0) return '0.5m';
        if ($altura < 1.5) return '1.0m';
        if ($altura < 2.0) return '1.5m';
        return '2.0m+';
    }

    private function getIcon($altura)
    {
        if ($altura < 1) {
            $file = 'onda-ruim.png';
        } elseif ($altura < 2) {
            $file = 'onda-regular.png';
        } else {
            $file = 'onda-boa.png';
        }

        return [
            'url' => asset("images/{$file}"),
            'path' => public_path("images/{$file}"),
        ];
    }

    private function grausParaDirecao($graus, $full = true)
    {
        if ($graus === null) return '-';

        $direcoes = [
            ['N', 'Norte'],
            ['NE', 'Nordeste'],
            ['E', 'Leste'],
            ['SE', 'Sudeste'],
            ['S', 'Sul'],
            ['SW', 'Sudoeste'],
            ['W', 'Oeste'],
            ['NW', 'Noroeste'],
        ];

        $index = round($graus / 45) % 8;

        return $full ? $direcoes[$index][1] : $direcoes[$index][0];
    }

    public function resumo($periodo)
    {
        if (!$periodo) {
            return 'Sem dados disponíveis.';
        }

        $altura = isset($periodo['altura'])
            ? floatval(str_replace(['m'], '', $periodo['altura']))
            : 0;

        $vento = $periodo['vento'] ?? 0;
        $ventoDir = $periodo['vento_dir'] ?? '-';

        if ($altura < 0.7) {
            return "Mar fraco e ondas pequenas.";
        }

        if ($altura < 1.5) {
            return "Ondas médias com vento {$ventoDir} a {$vento} km/h.";
        }

        if ($altura >= 1.5 && $vento < 10) {
            return "Boas condições com vento fraco de {$ventoDir}.";
        }

        return "Ondas irregulares com vento forte de {$ventoDir}.";
    }
}