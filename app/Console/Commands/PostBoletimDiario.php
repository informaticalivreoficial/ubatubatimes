<?php

namespace App\Console\Commands;

use App\Services\GerarBoletimCardService;
use App\Services\OndasService;
use App\Services\PrevisaoTempoService;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;

class PostBoletimDiario extends Command
{
    protected $signature = 'boletim:postar';
    protected $description = 'Gera o card e envia para o Make';

    public function handle()
    {
        try {
            $ondas = app(OndasService::class)->get();
            $tempo = app(PrevisaoTempoService::class)->getBoletim();

            $path = app(GerarBoletimCardService::class)->handle($ondas, $tempo);

            $relativePath = 'boletins/' . basename($path);
            $url = url($relativePath) . '?v=' . time();

            $caption  = "🌊 Boletim de Surf - Ubatuba\n\n";
            $caption .= "📊 " . $ondas['resumo']['geral'] . "\n\n";
            $caption .= "🌅 Manhã: " . $ondas['resumo']['manha'] . "\n";
            $caption .= "🌇 Tarde: " . $ondas['resumo']['tarde'] . "\n\n";
            $caption .= "#surf #ubatuba #ondas #previsaodotempo";

            $response = Http::post(config('services.make.webhook'), [
                'image'   => $url,
                'caption' => $caption,
            ]);

            if ($response->failed()) {
                $this->error('Make retornou erro: ' . $response->status());
                return Command::FAILURE;
            }

            $this->info('Boletim enviado com sucesso!');
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Erro: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
