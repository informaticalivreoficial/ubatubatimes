<?php

use App\Http\Controllers\Api\BalneabilidadeController;
use App\Http\Controllers\Api\CardBalneabilidadeController;
use App\Http\Controllers\Api\CleanupController;
use App\Http\Controllers\Webhook\PagHiperWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/webhook/paghiper', [PagHiperWebhookController::class, 'handle'])->name('webhook.paghiper');
Route::middleware('api.token')->get('/balneabilidade/{cidade}', BalneabilidadeController::class);
Route::middleware('api.token')->post('/card/generate', [CardBalneabilidadeController::class, 'generate']);

//Limpa Pasta Cards e Boletins após postagem nas Redes Sociais
Route::middleware('api.token')->post('/cleanup', [CleanupController::class, 'clean']);
