<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\{
    GuiaController,
    RssFeedController,
    SiteController,
};
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard\Companies\CatCompanies;
use App\Livewire\Dashboard\Companies\Companies;
use App\Livewire\Dashboard\Companies\CompanyForm;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Dashboard\Menu\Index;
use App\Livewire\Dashboard\Posts\CatPosts;
use App\Livewire\Dashboard\Posts\Lixeira;
use App\Livewire\Dashboard\Posts\PostForm;
use App\Livewire\Dashboard\Posts\Posts;
use App\Livewire\Dashboard\Reports\Posts as ReportsPosts;
use App\Livewire\Dashboard\Settings;
use App\Livewire\Dashboard\Sitemap\SitemapGenerator;
use App\Livewire\Dashboard\Users\Form;
use App\Livewire\Dashboard\Users\Time;
use App\Livewire\Dashboard\Users\Users;
use App\Livewire\Dashboard\Users\ViewUser;
use App\Livewire\Dashboard\Vendas\AdContractForm;
use App\Livewire\Dashboard\Vendas\AdContractIndex;
use App\Livewire\Dashboard\Vendas\AdForm;
use App\Livewire\Dashboard\Vendas\AdIndex;
use App\Livewire\Dashboard\Vendas\InvoiceIndex;

// use App\Services\OndasService;
// use App\Services\PrevisaoTempoService;
// use App\Services\GerarBoletimCardService;

Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {

    /** Página Inicial */   
    Route::get('/', [SiteController::class, 'home'])->name('home'); 
    
    //****************************** Páginas ******************************/
    Route::get('/politica-de-privacidade', [SiteController::class, 'politica'])->name('politica');
    Route::get('/boletim-das-ondas', [SiteController::class, 'ondas'])->name('ondas');
    Route::get('/previsao-do-tempo', [SiteController::class, 'tempo'])->name('tempo');
    Route::get('/condicao-das-praias', [SiteController::class, 'balneabilidade'])->name('balneabilidade');
    Route::get('/anunciar', [SiteController::class, 'anunciar'])->name('anunciar');

    // //****************************** Guia ******************************/
    Route::get('/guia-ubatuba', [GuiaController::class, 'guiaUbatuba'])->name('guiaUbatuba');
    Route::get('/guia-ubatuba/{slug}', [GuiaController::class, 'guiaEmpresa'])->name('guiaEmpresa');
    Route::get('/guia-ubatuba/categoria/{slug}', [GuiaController::class, 'guiaCategoria'])->name('guiaCategoria');
    Route::get('/guia-ubatuba/categoria/subcategoria/{slug}', [GuiaController::class, 'guiaSubCategoria'])->name('guiaSubCategoria');
    Route::get('/sendEmailEmpresa', [GuiaController::class, 'sendEmailEmpresa'])->name('sendEmailEmpresa');
    
    Route::get('/blog/artigo/{slug}', [SiteController::class, 'artigo'])->name('blog.artigo');
    Route::get('/blog/categoria/{slug}', [SiteController::class, 'categoria'])->name('blog.categoria');
    Route::get('/blog', [SiteController::class, 'artigos'])->name('blog.artigos');
    
    // //*************************************** Páginas *******************************************/
    Route::get('/noticia/{slug}', [SiteController::class, 'noticia'])->name('noticia');
    Route::get('/noticias', [SiteController::class, 'noticias'])->name('noticias');
    Route::get('/noticias/categoria/{slug}', [SiteController::class, 'categoria'])->name('noticia.categoria');
    
    // //** Pesquisa */
    Route::match(['post', 'get'], '/pesquisa', [SiteController::class, 'pesquisa'])->name('pesquisa');

    //** FEED */    
    Route::get('feed', [RssFeedController::class, 'feed'])->name('feed');


    // Route::get('/teste-card', function () {

    //     $ondas = app(OndasService::class)->get();
    //     $tempo = app(PrevisaoTempoService::class)->getBoletim();

    //     $path = app(GerarBoletimCardService::class)->handle($ondas, $tempo);

    //     return response()->file($path);
    // });
});

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'admin'], function () {

    Route::get('/', Dashboard::class)->name('admin');
    Route::get('configuracoes', Settings::class)->name('settings');
    Route::get('sitemap-generator', SitemapGenerator::class)->name('sitemap.generator');

    //*********************** Empresas **********************************************/
    Route::get('empresas', Companies::class)->name('companies.index');
    Route::get('empresas/cadastrar-empresa', CompanyForm::class)->name('companies.create');
    Route::get('empresas/{company}/editar-empresa', CompanyForm::class)->name('companies.edit');
    Route::get('empresas/categorias', CatCompanies::class)->name('companies.categories.index'); 

    //*********************** Usuários **********************************************/
    Route::get('usuarios/clientes', Users::class)->name('users.index');
    Route::get('usuarios/time', Time::class)->name('users.time');
    Route::get('usuarios/cadastrar', Form::class)->name('users.create');
    Route::get('usuarios/{userId}/editar', Form::class)->name('users.edit');
    Route::get('usuarios/{user}/visualizar', ViewUser::class)->name('users.view'); 

    //*********************** Posts *********************************************/
    Route::get('posts/{post}/editar', PostForm::class)->name('posts.edit');
    Route::get('posts/cadastrar', PostForm::class)->name('posts.create');
    Route::get('posts/categorias', CatPosts::class)->name('posts.categories.index');
    Route::get('/posts/lixeira', Lixeira::class)->name('posts.lixeira');
    Route::get('posts', Posts::class)->name('posts.index');

    Route::get('posts/reports', ReportsPosts::class)->name('posts.reports');

    //*********************** Vendas *********************************************/
    Route::get('anuncios', AdIndex::class)->name('vendas.ads.index');
    Route::get('anuncios/create', AdForm::class)->name('vendas.ads.create');
    Route::get('anuncios/{ad}/edit', AdForm::class)->name('vendas.ads.edit');

    Route::get('contratos', AdContractIndex::class)->name('vendas.contracts.index');
    Route::get('contratos/create', AdContractForm::class)->name('vendas.contracts.create');
    Route::get('contratos/{contract}/edit', AdContractForm::class)->name('vendas.contracts.edit');

    Route::get('faturas', InvoiceIndex::class)->name('vendas.invoices.index');

    Route::get('menus', Index::class)->name('menus.index');
    
});

// Authentication routes
Route::group(['prefix' => 'auth'], function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});
