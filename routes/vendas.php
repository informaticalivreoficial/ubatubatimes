<?php

use App\Http\Controllers\Admin\{
    AnunciosController,
    BancoController,
    FaturaController,
    PlanoController
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {    
    Route::match(['get', 'post'],'pagar/{fatura}', [FaturaController::class, 'pagar'])->name('pagar');
    Route::match(['get', 'post'],'notification', [FaturaController::class, 'getTransaction'])->name('getTransaction');
    Route::get('canlelar-boleto/{data}', [FaturaController::class, 'cancelarBoleto'])->name('cancelarBoleto');
    Route::get('status-do-boleto', [FaturaController::class, 'statusBoleto'])->name('statusBoleto');
});

Route::prefix('admin')->middleware('auth')->group( function(){

    //******************** Vendas *************************************************************/
    Route::get('bancos', [BancoController::class, 'index'])->name('bancos.index');
    Route::get('bancos/refresh', [BancoController::class, 'refresh'])->name('bancos.refresh');

    //******************** Faturas *************************************************************/
    Route::get('faturas/show/{id}', [FaturaController::class, 'show'])->name('faturas.show');
    Route::put('faturas/{id}', [FaturaController::class, 'update'])->name('faturas.update');
    Route::get('faturas/{id}/edit', [FaturaController::class, 'edit'])->name('faturas.edit');
    Route::get('faturas/create', [FaturaController::class, 'create'])->name('faturas.create');
    Route::post('faturas/store', [FaturaController::class, 'store'])->name('faturas.store');
    Route::get('/faturas', [FaturaController::class, 'faturas'])->name('faturas.index');
    Route::post('/create-fatura-unica/{pedido}', [FaturaController::class, 'pagarFaturaUnica'])->name('faturas.pagarFaturaUnica');

    //********************************* Anúncios *******************************************/
    Route::get('anuncios/set-status', [AnunciosController::class, 'anuncioSetStatus'])->name('anuncios.anuncioSetStatus');
    Route::get('anuncios/delete', [AnunciosController::class, 'delete'])->name('anuncios.delete');
    Route::put('anuncios/{id}', [AnunciosController::class, 'update'])->name('anuncios.update');
    Route::get('anuncios/{id}/edit', [AnunciosController::class, 'edit'])->name('anuncios.edit');
    Route::get('anuncios/create', [AnunciosController::class, 'create'])->name('anuncios.create');
    Route::post('anuncios/store', [AnunciosController::class, 'store'])->name('anuncios.store');
    Route::get('/anuncios', [AnunciosController::class, 'index'])->name('anuncios.index');
    
    /******************** Planos *************************************************************/
    Route::match(['get', 'post'], 'planos/pesquisa', [PlanoController::class, 'search'])->name('planos.search');
    Route::get('planos/delete', [PlanoController::class, 'delete'])->name('planos.delete');
    Route::delete('planos/deleteon', [PlanoController::class, 'deleteon'])->name('planos.deleteon');
    Route::get('planos/set-status', [PlanoController::class, 'planosetStatus'])->name('plano.setStatus');
    Route::put('planos/{id}', [PlanoController::class, 'update'])->name('planos.update');
    Route::get('planos/{id}/edit', [PlanoController::class, 'edit'])->name('planos.edit');
    Route::get('planos/create', [PlanoController::class, 'create'])->name('planos.create');
    Route::post('planos/store', [PlanoController::class, 'store'])->name('planos.store');
    Route::get('planos', [PlanoController::class, 'index'])->name('planos.index');    
});

Auth::routes();
