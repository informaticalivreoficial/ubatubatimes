<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
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
     * Quantidade de praias próprias (classificação diferente de "Imprópria")
     */
    public function getQtdProprias(string $cidade): int
    {
        return collect($this->getFeatures($cidade))
            ->filter(fn ($item) =>
                ($item['attributes']['classificacao_texto'] ?? null) !== 'Imprópria'
            )
            ->pluck('attributes.praia')
            ->unique()
            ->count();
    }

    /**
     * Resumo numérico: total monitorado, próprias e impróprias
     */
    public function getResumo(string $cidade): array
    {
        $totalPraias = collect($this->getFeatures($cidade))
            ->pluck('attributes.praia')
            ->unique()
            ->count();

        $improprias = $this->getImprorprias($cidade);

        return [
            'resultados' => $totalPraias,
            'proprias' => $totalPraias - count($improprias),
            'improprias' => count($improprias),
        ];
    }

    /**
     * Mensagem textual humana para redes sociais / resumo do card
     * (ex: "✅ Nenhuma praia de Ubatuba está imprópria para banho hoje.")
     */
    public function generateMessage(string $cidade): string
    {
        $improprias = $this->getImprorprias($cidade);

        if (empty($improprias)) {
            return "Nenhuma praia de {$cidade} está imprópria para banho hoje.";
        }

         return "Hoje as praias " .
            collect($improprias)
                ->map(fn ($praia) => Str::title(strtolower($praia)))
                ->implode(', ') .
            " estão impróprias para banho em {$cidade}.";
    }

    /**
     * Bloco estruturado (resultados/próprias/impróprias/data) usado
     * para posicionar os números no card, separado da mensagem humana.
     */
    public function generateResumoNumerico(string $cidade): string
    {
        $resumo = $this->getResumo($cidade);
        $data = $this->getUltimaAtualizacao($cidade) ?? Carbon::now()->format('d/m/Y');

        return "{$resumo['resultados']}\n"
            . "{$resumo['proprias']}\n"
            . "{$resumo['improprias']}\n"
            . "{$data}";
    }

    /**
     * Payload final da API
     */
    public function getPayload(string $cidade): array
    {
        $resumo = $this->getResumo($cidade);

        return [
            'cidade' => strtoupper($cidade),
            'message' => $this->generateMessage($cidade),
            'resultados' => $resumo['resultados'],
            'proprias' => $resumo['proprias'],
            'improprias' => $resumo['improprias'],
            'improprias_lista' => $this->getImprorprias($cidade),
            'ultima_atualizacao' => $this->getUltimaAtualizacao($cidade),
        ];
    }
}