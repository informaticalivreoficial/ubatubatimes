<?php

namespace App\Providers;

use App\Models\Anuncio;
use App\Models\CatPost;
use App\Models\Empresa;
use App\Models\NewsletterCat;
use App\Models\Post;
use App\Observers\EmpresaObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // URL::forceScheme('https');
        // Empresa::observe(EmpresaObserver::class);

        // Schema::defaultStringLength(191);
        // Blade::aliasComponent('admin.components.message', 'message');

        // $configuracoes = \App\Models\Configuracoes::find(1); 
        // View()->share('configuracoes', $configuracoes);

        // //Região Categorias de Notícias
        // $catnoticias = CatPost::where('tipo', 'noticia')
        //                 ->available()
        //                 ->whereNotNull('id_pai')
        //                 ->get();
        // View()->share('catnoticias', $catnoticias);

        // //Colunas Categorias
        // $catcolunas = CatPost::where('tipo', 'artigo')
        //                 ->available()
        //                 ->whereNotNull('id_pai')
        //                 ->get();
        // View()->share('catcolunas', $catcolunas);

        // //Newsletter
        // $newsletter = NewsletterCat::whereNotNull('sistema')
        //                 ->available()
        //                 ->first();
        // View()->share('newsletterForm', $newsletter);

        // //Anúncio Topo Home 729x90
        // $positionTopohome = Anuncio::where('plan_id', 3)->available()->limit(1)->get();
        // View()->share('positionTopohome', $positionTopohome);

        // Paginator::useBootstrap();
    }
}
