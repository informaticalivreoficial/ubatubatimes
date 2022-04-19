<?php

namespace App\Providers;

use App\Models\CatPost;
use App\Models\NewsletterCat;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Schema::defaultStringLength(191);
        Blade::aliasComponent('admin.components.message', 'message');

        $configuracoes = \App\Models\Configuracoes::find(1); 
        View()->share('configuracoes', $configuracoes);

        //Região Categorias de Notícias
        $catnoticias = CatPost::where('tipo', 'noticia')
                        ->available()
                        ->whereNotNull('id_pai')
                        ->get();
        View()->share('catnoticias', $catnoticias);

        //Colunas Categorias
        $catcolunas = CatPost::where('tipo', 'artigo')
                        ->available()
                        ->whereNotNull('id_pai')
                        ->get();
        View()->share('catcolunas', $catcolunas);

        //Newsletter
        $newsletter = NewsletterCat::whereNotNull('sistema')
                        ->available()
                        ->first();
        View()->share('newsletterForm', $newsletter);

        // //Páginas no menu frontend
        // $servicos = Post::orderBy('created_at', 'ASC')
        //                 ->postson()
        //                 ->where('categoria', 9)
        //                 ->get();
        // View()->share('menu_servicos', $servicos);

        Paginator::useBootstrap();
    }
}
