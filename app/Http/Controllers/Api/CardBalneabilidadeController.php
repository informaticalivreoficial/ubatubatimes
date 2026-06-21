<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BalneabilidadeService;
use App\Services\CardBalneabilidadeGeneratorService;
use Illuminate\Http\Request;

class CardBalneabilidadeController extends Controller
{
    public function __construct(
        private BalneabilidadeService $balneabilidadeService,
        private CardBalneabilidadeGeneratorService $cardService
    ) {}

    public function generate(Request $request)
    {
        $request->validate([
            'cidade' => 'required|string|max:120',
            'template' => 'nullable|string',
        ]);

        // 1. busca dados reais
        $data = $this->balneabilidadeService->getPayload($request->cidade);

        // 2. gera card
        $url = $this->cardService->make(
            $data,
            $request->template ?? 'card-balneabilidade.png'
        );

        return response()->json([
            'url' => $url,
            'data' => $data,
        ]);
    }
}