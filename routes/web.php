<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AdminController,
    UserController,
    EmailController,
    PostController,
    CatPostController,
    ConfigController,
    EmpresaController,
    NewsletterController,
    SitemapController,
    SlideController
};
use App\Http\Controllers\Web\{
    GuiaController,
    RssFeedController,
    SendEmailController,
    SiteController,
    WebController
};
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard\Companies\Companies;
use App\Livewire\Dashboard\Companies\CompanyForm;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Dashboard\Posts\CatPostForm;
use App\Livewire\Dashboard\Posts\PostForm;
use App\Livewire\Dashboard\Posts\Posts;
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

Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {

    /** Página Inicial */   
    Route::get('/', [SiteController::class, 'home'])->name('home');     

    Route::get('/pagina/{slug}', [SiteController::class, 'page'])->name('page');

    //****************************** Páginas ******************************/
    Route::get('/politica-de-privacidade', [WebController::class, 'politica'])->name('politica');
    Route::get('/boletim-das-ondas', [SiteController::class, 'ondas'])->name('ondas');
    Route::get('/previsao-do-tempo', [WebController::class, 'tempo'])->name('tempo');
    Route::get('/anunciar', [SiteController::class, 'anunciar'])->name('anunciar');

    // //****************************** Guia ******************************/
    Route::get('/guia-ubatuba', [GuiaController::class, 'guiaUbatuba'])->name('guiaUbatuba');
    Route::get('/guia-ubatuba/{slug}', [GuiaController::class, 'guiaEmpresa'])->name('guiaEmpresa');
    Route::get('/guia-ubatuba/categoria/{slug}', [GuiaController::class, 'guiaCategoria'])->name('guiaCategoria');
    Route::get('/guia-ubatuba/categoria/subcategoria/{slug}', [GuiaController::class, 'guiaSubCategoria'])->name('guiaSubCategoria');
    Route::get('/sendEmailEmpresa', [GuiaController::class, 'sendEmailEmpresa'])->name('sendEmailEmpresa');
    
    // //**************************** Emails ********************************************/
    // Route::get('/atendimento', [WebController::class, 'atendimento'])->name('atendimento');
    // Route::get('/sendOrcamento', [SendEmailController::class, 'sendOrcamento'])->name('sendOrcamento');
    // Route::get('/sendEmail', [SendEmailController::class, 'sendEmail'])->name('sendEmail');
    // Route::get('/sendNewsletter', [SendEmailController::class, 'sendNewsletter'])->name('sendNewsletter');
    // Route::get('/sendFormCaptacao', [SendEmailController::class, 'sendFormCaptacao'])->name('sendFormCaptacao');
    
    // //****************************** Blog ***********************************************/
    Route::get('/blog/artigo/{slug}', [WebController::class, 'artigo'])->name('blog.artigo');
    Route::get('/blog/categoria/{slug}', [WebController::class, 'categoria'])->name('blog.categoria');
    Route::get('/blog', [WebController::class, 'artigos'])->name('blog.artigos');
    Route::match(['get', 'post'],'/blog/pesquisar', [WebController::class, 'searchBlog'])->name('blog.searchBlog');

    // //*************************************** Páginas *******************************************/
    Route::get('/pagina/{slug}', [WebController::class, 'pagina'])->name('pagina');
    Route::get('/noticia/{slug}', [WebController::class, 'noticia'])->name('noticia');
    Route::get('/noticias', [WebController::class, 'noticias'])->name('noticias');
    Route::get('/noticias/categoria/{slug}', [WebController::class, 'categoria'])->name('noticia.categoria');
    
    // //** Pesquisa */
    Route::match(['post', 'get'], '/pesquisa', [WebController::class, 'pesquisa'])->name('pesquisa');

    // //** FEED */    
    // Route::get('feed', [RssFeedController::class, 'feed'])->name('feed');
    

});

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'admin'], function () {

    Route::get('/', Dashboard::class)->name('admin');
    Route::get('configuracoes', Settings::class)->name('settings');
    Route::get('sitemap-generator', SitemapGenerator::class)->name('sitemap.generator');

    Route::get('empresas', Companies::class)->name('companies.index');
    Route::get('empresas/cadastrar-empresa', CompanyForm::class)->name('companies.create');
    Route::get('empresas/{company}/editar-empresa', CompanyForm::class)->name('companies.edit'); 

    //*********************** Usuários **********************************************/
    Route::get('usuarios/clientes', Users::class)->name('users.index');
    Route::get('usuarios/time', Time::class)->name('users.time');
    Route::get('usuarios/cadastrar', Form::class)->name('users.create');
    Route::get('usuarios/{user}/editar', Form::class)->name('users.edit');
    Route::get('usuarios/{user}/visualizar', ViewUser::class)->name('users.view'); 

    //*********************** Posts *********************************************/
    Route::get('posts/{post}/editar', PostForm::class)->name('posts.edit');
    Route::get('posts/cadastrar', PostForm::class)->name('posts.create');
    Route::get('posts/categorias', CatPostForm::class)->name('posts.categories.index');
    Route::get('posts', Posts::class)->name('posts.index');

    Route::get('ads', AdIndex::class)->name('ads.index');
    Route::get('ads/create', AdForm::class)->name('ads.create');
    Route::get('ads/{ad}/edit', AdForm::class)->name('ads.edit');

    Route::get('contracts', AdContractIndex::class)->name('contracts.index');
    Route::get('contracts/create', AdContractForm::class)->name('contracts.create');
    Route::get('contracts/{contract}/edit', AdContractForm::class)->name('contracts.edit');
    
});

// Authentication routes
Route::group(['prefix' => 'auth'], function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});
