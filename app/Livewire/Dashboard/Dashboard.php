<?php

namespace App\Livewire\Dashboard;

use App\Models\Ad;
use App\Models\AdContract;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Post;
use Livewire\Component;

class Dashboard extends Component
{
    public $topcompanies = [];

    public function render()
    {
        $companyCount = Company::count();
        $companyYearCount = Company::whereYear('created_at', now()->year)->count();  

        $noticiasCount = Post::where('type', 'noticia')->count();
        $noticiasYearCount = Post::where('type', 'noticia')->whereYear('created_at', now()->year)->count();

        $articlesCount = Post::where('type', 'artigo')->count();
        $articlesYearCount = Post::where('type', 'artigo')->whereYear('created_at', now()->year)->count();
        
        $invoices = Invoice::where('status', 'paid')->whereMonth('paid_at', now()->month)->sum('amount');
        $invoicePending = Invoice::where('status', 'pending')->count();
        $activeAds = Ad::where('active', true)->count();  
        
        $contracts = AdContract::where('active', true)->get();        

        $anuncios = Ad::where('active', true)->get();
        

        $title = 'Painel de Controle';

        return view('livewire.dashboard.dashboard', [
            'title' => $title,
            'companyCount' => $companyCount,
            'companyYearCount' => $companyYearCount,
            'invoices' => $invoices,
            'invoicePending' => $invoicePending,
            'activeAds' => $activeAds,
            'noticiasCount' => $noticiasCount,
            'noticiasYearCount' => $noticiasYearCount,
            'articlesCount' => $articlesCount,
            'articlesYearCount' => $articlesYearCount,
            'contracts' => $contracts,
            'anuncios' => $anuncios,
        ]);
    }
}
