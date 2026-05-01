<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PrevisaoTempoService
{
    private const URL = 'http://servicos.cptec.inpe.br/XML/cidade/5515/previsao.xml';

    private const PREVISOES = [
        'ec'  => 'Encoberto com Chuvas Isoladas',
        'ci'  => 'Chuvas Isoladas',
        'c'   => 'Chuva',
        'in'  => 'Instável',
        'pp'  => 'Poss. de Pancadas de Chuva',
        'cm'  => 'Chuva pela Manhã',
        'cn'  => 'Chuva a Noite',
        'pt'  => 'Pancadas de Chuva a Tarde',
        'pm'  => 'Pancadas de Chuva pela Manhã',
        'np'  => 'Nublado e Pancadas de Chuva',
        'pc'  => 'Pancadas de Chuva',
        'pn'  => 'Parcialmente Nublado',
        'cv'  => 'Chuvisco',
        'ch'  => 'Chuvoso',
        't'   => 'Tempestade',
        'ps'  => 'Predomínio de Sol',
        'e'   => 'Encoberto',
        'n'   => 'Nublado',
        'cl'  => 'Céu Claro',
        'nv'  => 'Nevoeiro',
        'g'   => 'Geada',
        'pnt' => 'Pancadas de Chuva a Noite',
        'psc' => 'Possibilidade de Chuva',
        'pcm' => 'Possibilidade de Chuva pela Manhã',
        'pct' => 'Possibilidade de Chuva a Tarde',
        'pcn' => 'Possibilidade de Chuva a Noite',
        'npt' => 'Nublado com Pancadas a Tarde',
        'npn' => 'Nublado com Pancadas a Noite',
        'ncn' => 'Nublado com Poss. de Chuva a Noite',
        'nct' => 'Nublado com Poss. de Chuva a Tarde',
        'ncm' => 'Nubl. c/ Poss. de Chuva pela Manhã',
        'npm' => 'Nublado com Pancadas pela Manhã',
        'npp' => 'Nublado com Possibilidade de Chuva',
        'vn'  => 'Variação de Nebulosidade',
        'ct'  => 'Chuva a Tarde',
        'ppn' => 'Poss. de Panc. de Chuva a Noite',
        'ppt' => 'Poss. de Panc. de Chuva a Tarde',
        'ppm' => 'Poss. de Panc. de Chuva pela Manhã',
    ];

    private const IMAGENS = [
        'ec'  => 'sol-com-pancadas.png',
        'ci'  => 'sol-com-pancadas.png',
        'c'   => 'chuva.png',
        'in'  => 'sol-com-pancadas.png',
        'pp'  => 'sol-com-pancadas.png',
        'cm'  => 'chuva.png',
        'cn'  => 'chuva.png',
        'pt'  => 'sol-com-pancadas.png',
        'pm'  => 'sol-com-pancadas.png',
        'np'  => 'sol-com-pancadas.png',
        'pc'  => 'sol-com-pancadas.png',
        'pn'  => 'encoberto.png',
        'cv'  => 'chuva.png',
        'ch'  => 'chuva.png',
        't'   => 'tempestade.png',
        'ps'  => 'sol.png',
        'e'   => 'encoberto.png',
        'n'   => 'nublado.png',
        'cl'  => 'sol.png',
        'nv'  => 'encoberto.png',
        'pnt' => 'pancadas-noite.png',
        'psc' => 'sol-com-pancadas.png',
        'pcm' => 'sol-com-pancadas.png',
        'pct' => 'sol-com-pancadas.png',
        'pcn' => 'sol-com-pancadas.png',
        'npt' => 'sol-com-pancadas.png',
        'npn' => 'sol-com-pancadas.png',
        'ncn' => 'sol-com-pancadas.png',
        'nct' => 'sol-com-pancadas.png',
        'ncm' => 'sol-com-pancadas.png',
        'npm' => 'sol-com-pancadas.png',
        'npp' => 'sol-com-pancadas.png',
        'vn'  => 'encoberto.png',
        'ct'  => 'sol-com-pancadas.png',
        'ppn' => 'sol-com-pancadas.png',
        'ppt' => 'sol-com-pancadas.png',
        'ppm' => 'sol-com-pancadas.png',
    ];

    public function getBoletim(): ?array
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, self::URL);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $data = curl_exec($ch);
            curl_close($ch);

            $result = simplexml_load_string($data);

            if (!$result) return null;

            $response = [];
            foreach ($result->previsao as $item) {
                $sigla = (string) $item->tempo;
                $response[] = [
                    'data'      => Carbon::parse($item->dia)->translatedFormat('l d/m/Y'),
                    'img'       => self::IMAGENS[$sigla]   ?? 'sol.png',
                    'previsao'  => self::PREVISOES[$sigla] ?? 'Sem previsão',
                    'minima'    => (string) $item->minima,
                    'maxima'    => (string) $item->maxima,
                    'iuv'       => (string) $item->iuv,
                    'iuvcolor'  => $this->getUvColor((int) $item->iuv),
                ];
            }

            return $response;

        } catch (\Exception $e) {
            Log::error('Erro ao buscar previsão do tempo', ['error' => $e->getMessage()]);
            return null;
        }
    }

    private function getUvColor(int $valor): string
    {
        return match(true) {
            $valor <= 2              => 'color:#000;',
            $valor >= 3 && $valor <= 5  => 'color:#000;background:#fff336;',
            $valor >= 6 && $valor <= 7  => 'color:#000;background:#EDAC43;',
            $valor >= 8 && $valor <= 10 => 'color:#fff;background:#D92927;',
            $valor >= 11             => 'color:#fff;background:#C72BB2;',
            default                  => 'color:#000;',
        };
    }
}