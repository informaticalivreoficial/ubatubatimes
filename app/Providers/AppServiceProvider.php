<?php

namespace App\Providers;

use App\Models\CatPost;
use App\Models\Config;
use App\Models\Post;
use App\Services\CotacaoService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ImageManager::class, function () {
            return new ImageManager(new Driver());
        });

        $this->app->singleton('site.view.data', fn (): array => $this->buildSharedViewData());
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/livewire/update', $handle)
                ->middleware('web')
                ->name('livewire.update');
        });

        Livewire::setScriptRoute(function ($handle) {
            return Route::get('/livewire/livewire.js', $handle)
                ->name('livewire.js');
        });

        // Schema::defaultStringLength(191);
        // Blade::aliasComponent('admin.components.message', 'message');

        // Os dados abaixo dependem do banco e só são necessários quando uma view é
        // renderizada. Ficam em um composer para não consultarem o banco em comandos
        // de console (config:cache, route:cache, etc. rodam no build).
        View::composer('*', function ($view) {
            $view->with(app('site.view.data'));
        });

        //Paginator::useBootstrap();

        Paginator::defaultView('vendor.pagination.tailwind');
    }

    /**
     * Dados compartilhados com todas as views (carregados uma única vez por request).
     *
     * @return array<string, mixed>
     */
    private function buildSharedViewData(): array
    {
        try {
            $config = Config::find(1);
        } catch (\Throwable $e) {
            $config = null;
        }

        return [
            'config' => $config,
            //Região Categorias de Notícias
            'catnoticias' => CatPost::where('type', 'noticia')
                ->active()
                ->whereNotNull('id_pai')
                ->get(),
            //Colunas Categorias
            'catcolunas' => CatPost::where('type', 'artigo')
                ->active()
                ->whereNotNull('id_pai')
                ->get(),
            //Newsletter
            // 'newsletterForm' => NewsletterCat::whereNotNull('sistema')->available()->first(),
            'cotacao' => app(CotacaoService::class)->getDolar(),
        ];
    }
}
