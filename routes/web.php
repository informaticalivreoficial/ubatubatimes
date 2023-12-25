<?php

use Illuminate\Support\Facades\Auth;
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
    WebController
};

Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {

    /** Página Inicial */   
    Route::get('/', [WebController::class, 'home'])->name('home');     

    //****************************** Páginas ******************************/
    Route::get('/politica-de-privacidade', [WebController::class, 'politica'])->name('politica');
    Route::get('/boletim-das-ondas', [WebController::class, 'ondas'])->name('ondas');
    Route::get('/previsao-do-tempo', [WebController::class, 'tempo'])->name('tempo');
    Route::get('/anunciar', [WebController::class, 'anunciar'])->name('anunciar');

    //****************************** Guia ******************************/
    Route::get('/guia-ubatuba', [GuiaController::class, 'guiaUbatuba'])->name('guiaUbatuba');
    Route::get('/guia-ubatuba/{slug}', [GuiaController::class, 'guiaEmpresa'])->name('guiaEmpresa');
    Route::get('/guia-ubatuba/categoria/{slug}', [GuiaController::class, 'guiaCategoria'])->name('guiaCategoria');
    Route::get('/guia-ubatuba/categoria/subcategoria/{slug}', [GuiaController::class, 'guiaSubCategoria'])->name('guiaSubCategoria');
    Route::get('/sendEmailEmpresa', [GuiaController::class, 'sendEmailEmpresa'])->name('sendEmailEmpresa');
    
    //**************************** Emails ********************************************/
    Route::get('/atendimento', [WebController::class, 'atendimento'])->name('atendimento');
    Route::get('/sendOrcamento', [SendEmailController::class, 'sendOrcamento'])->name('sendOrcamento');
    Route::get('/sendEmail', [SendEmailController::class, 'sendEmail'])->name('sendEmail');
    Route::get('/sendNewsletter', [SendEmailController::class, 'sendNewsletter'])->name('sendNewsletter');
    Route::get('/sendFormCaptacao', [SendEmailController::class, 'sendFormCaptacao'])->name('sendFormCaptacao');
    
    //****************************** Blog ***********************************************/
    Route::get('/blog/artigo/{slug}', [WebController::class, 'artigo'])->name('blog.artigo');
    Route::get('/blog/categoria/{slug}', [WebController::class, 'categoria'])->name('blog.categoria');
    Route::get('/blog', [WebController::class, 'artigos'])->name('blog.artigos');
    Route::match(['get', 'post'],'/blog/pesquisar', [WebController::class, 'searchBlog'])->name('blog.searchBlog');

    //*************************************** Páginas *******************************************/
    Route::get('/pagina/{slug}', [WebController::class, 'pagina'])->name('pagina');
    Route::get('/noticia/{slug}', [WebController::class, 'noticia'])->name('noticia');
    Route::get('/noticias', [WebController::class, 'noticias'])->name('noticias');
    Route::get('/noticias/categoria/{slug}', [WebController::class, 'categoria'])->name('noticia.categoria');
    
    //** Pesquisa */
    Route::match(['post', 'get'], '/pesquisa', [WebController::class, 'pesquisa'])->name('pesquisa');

    //** FEED */    
    Route::get('feed', [RssFeedController::class, 'feed'])->name('feed');
    

});

Route::prefix('admin')->middleware('auth')->group( function(){

    //******************************* Newsletter *********************************************/
    Route::match(['post', 'get'], 'listas/padrao', [NewsletterController::class, 'padraoMark'])->name('listas.padrao');
    Route::get('listas/set-status', [NewsletterController::class, 'listaSetStatus'])->name('listas.listaSetStatus');
    Route::get('listas/delete', [NewsletterController::class, 'listaDelete'])->name('listas.delete');
    Route::delete('listas/deleteon', [NewsletterController::class, 'listaDeleteon'])->name('listas.deleteon');
    Route::put('listas/{id}', [NewsletterController::class, 'listasUpdate'])->name('listas.update');
    Route::get('listas/{id}/editar', [NewsletterController::class, 'listasEdit'])->name('listas.edit');
    Route::get('listas/cadastrar', [NewsletterController::class, 'listasCreate'])->name('listas.create');
    Route::post('listas/store', [NewsletterController::class, 'listasStore'])->name('listas.store');
    Route::get('listas', [NewsletterController::class, 'listas'])->name('listas');

    Route::get('listas/export/{lista}', [NewsletterController::class, 'emailExportCsv'])->name('listas.emailExportCsv');
    Route::post('listas/import/{lista}', [NewsletterController::class, 'emailImportCsv'])->name('listas.emailImportCsv');
    Route::put('listas/email/{id}', [NewsletterController::class, 'newsletterUpdate'])->name('listas.newsletter.update');
    Route::get('listas/email/set-status', [NewsletterController::class, 'emailSetStatus'])->name('emails.emailSetStatus');
    Route::get('listas/email/delete', [NewsletterController::class, 'emailDelete'])->name('emails.delete');
    Route::delete('listas/email/deleteon', [NewsletterController::class, 'emailDeleteon'])->name('emails.deleteon');
    Route::get('listas/email/{id}/edit', [NewsletterController::class, 'newsletterEdit'])->name('listas.newsletter.edit');
    Route::get('listas/email/cadastrar', [NewsletterController::class, 'newsletterCreate'])->name('lista.newsletter.create');
    Route::post('listas/email/store', [NewsletterController::class, 'newsletterStore'])->name('listas.newsletter.store');
    Route::get('listas/emails/categoria/{categoria}', [NewsletterController::class, 'newsletters'])->name('lista.newsletters');

    //******************* Slides ************************************************/
    Route::get('slides/set-status', [SlideController::class, 'slideSetStatus'])->name('slides.slideSetStatus');
    Route::get('slides/delete', [SlideController::class, 'delete'])->name('slides.delete');
    Route::delete('slides/deleteon', [SlideController::class, 'deleteon'])->name('slides.deleteon');
    Route::put('slides/{slide}', [SlideController::class, 'update'])->name('slides.update');
    Route::get('slides/{slide}/edit', [SlideController::class, 'edit'])->name('slides.edit');
    Route::get('slides/create', [SlideController::class, 'create'])->name('slides.create');
    Route::post('slides/store', [SlideController::class, 'store'])->name('slides.store');
    Route::get('slides', [SlideController::class, 'index'])->name('slides.index');

    //****************************** Empresas *******************************************/
    Route::match(['post', 'get'], 'empresas/fetchCity', [EmpresaController::class, 'fetchCity'])->name('empresas.fetchCity');
    Route::get('empresas/set-status', [EmpresaController::class, 'empresaSetStatus'])->name('empresas.empresaSetStatus');
    Route::delete('empresas/deleteon', [EmpresaController::class, 'deleteon'])->name('empresas.deleteon');
    Route::get('empresas/delete', [EmpresaController::class, 'delete'])->name('empresas.delete');
    Route::put('empresas/{id}', [EmpresaController::class, 'update'])->name('empresas.update');
    Route::get('empresas/{id}/edit', [EmpresaController::class, 'edit'])->name('empresas.edit');
    Route::get('empresas/create', [EmpresaController::class, 'create'])->name('empresas.create');
    Route::post('empresas/store', [EmpresaController::class, 'store'])->name('empresas.store');
    Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas.index');

    //********************* Categorias para Anúncios *******************************/
    Route::post('empresas/image-set-cover', [EmpresaController::class, 'imageSetCover'])->name('empresas.imageSetCover');
    Route::delete('empresas/image-remove', [EmpresaController::class, 'imageRemove'])->name('empresas.imageRemove');
    Route::match(['post', 'get'], 'empresas/categorias/fetchSubcategorias', [EmpresaController::class, 'fetchSubcategorias'])->name('empresas.categorias.fetchSubcategorias');
    Route::get('empresas/categorias/delete', [EmpresaController::class, 'categoriasDelete'])->name('empresas.categorias.delete');
    Route::delete('empresas/categorias/deleteon', [EmpresaController::class, 'categoriasDeleteon'])->name('empresas.categorias.deleteon');
    Route::put('empresas/categorias/posts/{id}', [EmpresaController::class, 'categoriasUpdate'])->name('empresas.categorias.update');
    Route::get('empresas/categorias/{id}/edit', [EmpresaController::class, 'categoriasEdit'])->name('empresas.categorias.edit');
    Route::match(['post', 'get'],'empresas/categorias/create/{catpai}', [EmpresaController::class, 'categoriasCreate'])->name('empresas.categorias.create');
    Route::post('empresas/categorias/store', [EmpresaController::class, 'categoriasStore'])->name('empresas.categorias.store');
    Route::get('empresas/categorias', [EmpresaController::class, 'categorias'])->name('empresas.categorias.index');

    //******************** Sitemap *********************************************/
    Route::get('gerarxml', [SitemapController::class, 'gerarxml'])->name('admin.gerarxml');

    //******************** Configurações ***************************************/
    Route::match(['post', 'get'], 'configuracoes/fetchCity', [ConfigController::class, 'fetchCity'])->name('configuracoes.fetchCity');
    Route::put('configuracoes/{config}', [ConfigController::class, 'update'])->name('configuracoes.update');
    Route::get('configuracoes', [ConfigController::class, 'editar'])->name('configuracoes.editar');

    //********************* Categorias para Posts *******************************/
    Route::get('categorias/delete', [CatPostController::class, 'delete'])->name('categorias.delete');
    Route::delete('categorias/deleteon', [CatPostController::class, 'deleteon'])->name('categorias.deleteon');
    Route::put('categorias/posts/{id}', [CatPostController::class, 'update'])->name('categorias.update');
    Route::get('categorias/{id}/edit', [CatPostController::class, 'edit'])->name('categorias.edit');
    Route::match(['post', 'get'],'posts/categorias/create/{catpai}', [CatPostController::class, 'create'])->name('categorias.create');
    Route::post('posts/categorias/store', [CatPostController::class, 'store'])->name('categorias.store');
    Route::get('posts/categorias', [CatPostController::class, 'index'])->name('categorias.index');

    //********************** Blog ************************************************/
    Route::get('posts/set-status', [PostController::class, 'postSetStatus'])->name('posts.postSetStatus');
    Route::get('posts/delete', [PostController::class, 'delete'])->name('posts.delete');
    Route::delete('posts/deleteon', [PostController::class, 'deleteon'])->name('posts.deleteon');
    Route::post('posts/image-set-cover', [PostController::class, 'imageSetCover'])->name('posts.imageSetCover');
    Route::delete('posts/image-remove', [PostController::class, 'imageRemove'])->name('posts.imageRemove');
    Route::put('posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::get('posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::post('posts/categoriaList', [PostController::class, 'categoriaList'])->name('posts.categoriaList');
    Route::get('posts/artigos', [PostController::class, 'index'])->name('posts.artigos');
    Route::get('posts/noticias', [PostController::class, 'index'])->name('posts.noticias');
    Route::get('posts/paginas', [PostController::class, 'index'])->name('posts.paginas');    
    Route::get('posts/lixeira', [PostController::class, 'trash'])->name('posts.trash');    

    //*********************** Email **********************************************/
    Route::get('email/suporte', [EmailController::class, 'suporte'])->name('email.suporte');
    Route::match(['post', 'get'], 'email/enviar-email', [EmailController::class, 'send'])->name('email.send');
    Route::post('email/sendEmail', [EmailController::class, 'sendEmail'])->name('email.sendEmail');
    Route::match(['post', 'get'], 'email/success', [EmailController::class, 'success'])->name('email.success');

    //*********************** Usuários *******************************************/
    Route::match(['get', 'post'], 'usuarios/pesquisa', [UserController::class, 'search'])->name('users.search');
    Route::match(['post', 'get'], 'usuarios/fetchCity', [UserController::class, 'fetchCity'])->name('users.fetchCity');
    Route::delete('usuarios/deleteon', [UserController::class, 'deleteon'])->name('users.deleteon');
    Route::get('usuarios/set-status', [UserController::class, 'userSetStatus'])->name('users.userSetStatus');
    Route::get('usuarios/delete', [UserController::class, 'delete'])->name('users.delete');
    Route::get('usuarios/time', [UserController::class, 'team'])->name('users.team');
    Route::get('usuarios/view/{id}', [UserController::class, 'show'])->name('users.view');
    Route::put('usuarios/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('usuarios/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('usuarios/create', [UserController::class, 'create'])->name('users.create');
    Route::post('usuarios/store', [UserController::class, 'store'])->name('users.store');
    Route::get('usuarios', [UserController::class, 'index'])->name('users.index');

    Route::get('/', [AdminController::class, 'home'])->name('home');

    //Cron POSTS
    //Route::get('posts/Cron', [PostController::class, 'deleteCron'])->name('posts.deleteCron');
});

Auth::routes();
