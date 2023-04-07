<?php

use App\Http\Controllers\Admin\{
    AnunciosController,
    FaturaController,
    PlanController,
    PlanoController
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {
    
    Route::get('pagar/{fatura}', [FaturaController::class, 'pagar'])->name('pagar');
    Route::get('notification', [FaturaController::class, 'retornoBoleto'])->name('retornoBoleto');
});

Route::prefix('admin')->middleware('auth')->group( function(){

    //********************************* Anúncios *******************************************/
    Route::get('anuncios/set-status', [AnunciosController::class, 'anuncioSetStatus'])->name('anuncios.anuncioSetStatus');
    Route::get('anuncios/delete', [AnunciosController::class, 'delete'])->name('anuncios.delete');
    Route::put('anuncios/{id}', [AnunciosController::class, 'update'])->name('anuncios.update');
    Route::get('anuncios/{id}/edit', [AnunciosController::class, 'edit'])->name('anuncios.edit');
    Route::get('anuncios/create', [AnunciosController::class, 'create'])->name('anuncios.create');
    Route::post('anuncios/store', [AnunciosController::class, 'store'])->name('anuncios.store');
    Route::get('/anuncios', [AnunciosController::class, 'index'])->name('anuncios.index');

    //********************************** Planos *******************************************/
    Route::get('anuncios/planos/set-status', [PlanController::class, 'planSetStatus'])->name('plans.planSetStatus');
    Route::put('anuncios/planos/{id}', [PlanController::class, 'update'])->name('plans.update');
    Route::get('anuncios/planos/{id}/edit', [PlanController::class, 'edit'])->name('plans.edit');
    Route::get('anuncios/planos/create', [PlanController::class, 'create'])->name('plans.create');
    Route::post('anuncios/planos/store', [PlanController::class, 'store'])->name('plans.store');
    Route::get('/anuncios/planos', [PlanController::class, 'index'])->name('plans');
    
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

    //******************** Faturas *************************************************************/
    Route::get('faturas/show/{id}', [FaturaController::class, 'show'])->name('faturas.show');
    Route::get('/faturas', [FaturaController::class, 'index'])->name('faturas.index');
});

Auth::routes();
