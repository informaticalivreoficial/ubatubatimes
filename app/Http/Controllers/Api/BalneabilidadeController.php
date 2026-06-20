<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BalneabilidadeService;
use Illuminate\Http\Request;

class BalneabilidadeController extends Controller
{
    public function __invoke(
        string $cidade,
        BalneabilidadeService $service
    ) {
        return response()->json(
            $service->getPayload($cidade)
        );
    }
}
