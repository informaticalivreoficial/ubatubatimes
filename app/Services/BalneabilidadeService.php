<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class BalneabilidadeService
{
    public function __construct(
        protected string $url = ''
    ) {
        $this->url = config('services.cetesb.query_url');
    }

    /**
     * Busca dados da CETESB com cache
     */
    public function getFeatures(string $cidade): array
    {
        $cidade = strtoupper(trim($cidade));

        return Cache::remember("balneabilidade_{$cidade}", 3600, function () use ($cidade) {

            $response = Http::timeout(10)->get($this->url, [
                'f' => 'json',
                'where' => "UPPER(municipio) = '{$cidade}'",
                'outFields' => 'praia,municipio,classificacao_texto,id_praia,data_atual',
                'returnGeometry' => 'false',
                'resultRecordCount' => 1000,
            ]);

            return $response->json('features') ?? [];
        });
    }

    /**
     * Última atualização geral
     */
    public function getUltimaAtualizacao(string $cidade): ?string
    {
        $features = $this->getFeatures($cidade);

        $timestamp = collect($features)
            ->pluck('attributes.data_atual')
            ->filter()
            ->max();

        if (!$timestamp) {
            return null;
        }

        return Carbon::createFromTimestampMs($timestamp)
            ->format('d/m/Y');
    }

    /**
     * Praias impróprias
     */
    public function getImprorprias(string $cidade): array
    {
        return collect($this->getFeatures($cidade))
            ->filter(fn ($item) =>
                ($item['attributes']['classificacao_texto'] ?? null) === 'Imprópria'
            )
            ->pluck('attributes.praia')
            ->unique()
            ->values()
            ->toArray();
    }

    /**
     * Mensagem para redes sociais
     */
    public function generateMessage(string $cidade): string
    {
        $improprias = $this->getImprorprias($cidade);

        if (empty($improprias)) {
            return "✅ Nenhuma praia de {$cidade} está imprópria para banho hoje.";
        }

        return "⚠️ Hoje as praias " .
            implode(', ', $improprias) .
            " estão impróprias para banho em {$cidade}.";
    }

    /**
     * Payload final da API
     */
    public function getPayload(string $cidade): array
    {
        return [
            'cidade' => strtoupper($cidade),
            'message' => $this->generateMessage($cidade),
            'improprias' => $this->getImprorprias($cidade),
            'ultima_atualizacao' => $this->getUltimaAtualizacao($cidade),
        ];
    }
}