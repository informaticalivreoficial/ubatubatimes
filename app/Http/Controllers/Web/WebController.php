<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Web\Atendimento;
use App\Mail\Web\AtendimentoRetorno;
use App\Mail\Web\Compra;
use App\Mail\Web\CompraRetorno;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    CatPortifolio,
    Post,
    CatPost,
    Estados,
    Newsletter,
    Slide,
    User
};
use Goutte\Client;
use App\Services\ConfigService;
use App\Support\Seo;
use Carbon\Carbon;

class WebController extends Controller
{
    protected $configService;
    protected $seo;
    private $results = [];

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
        $this->seo = new Seo();
        $this->crowler = new Client();
    }

    public function home()
    {
        $noticiasUbatuba = Post::orderBy('created_at', 'DESC')
                    ->where('tipo', 'noticia')
                    ->where('categoria', '!=', 16)
                    ->where('categoria', '!=', 17)
                    ->where('categoria', '!=', 18)
                    ->postson()
                    ->limit(3)
                    ->get();
        $noticiasCaragua = Post::orderBy('created_at', 'DESC')
                    ->where('tipo', 'noticia')
                    ->where('categoria', 16)
                    ->postson()
                    ->limit(2)
                    ->get();
        $noticiasSaoSebastiao = Post::orderBy('created_at', 'DESC')
                    ->where('tipo', 'noticia')
                    ->where('categoria', 17)
                    ->postson()
                    ->limit(2)
                    ->get();
        $noticiasIlhabela = Post::orderBy('created_at', 'DESC')
                    ->where('tipo', 'noticia')
                    ->where('categoria', 18)
                    ->postson()
                    ->limit(2)
                    ->get();

        $head = $this->seo->render($this->configService->getConfig()->nomedosite ?? 'Informática Livre',
            $this->configService->getConfig()->descricao ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.home'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

    	return view('web.home',[
            'head' => $head,
            'noticiasUbatuba'  => $noticiasUbatuba,
            'noticiasCaragua' => $noticiasCaragua,
            'noticiasSaoSebastiao' => $noticiasSaoSebastiao,
            'noticiasIlhabela' => $noticiasIlhabela,
		]);
}

    //public function home()
    //{
    //     $client = new Client();
    //     //URLS
    //     $urlUbatuba  = 'https://www.ubatuba.sp.gov.br/noticias/';
    //     $urlCaragua  = 'https://www.caraguatatuba.sp.gov.br/pmc/';
    //     $urlSaoSeba  = 'http://www.saosebastiao.sp.gov.br/noticia-lista.asp';
    //     $urlIlhaBela = 'https://www.ilhabela.sp.gov.br/noticias/';

    //     //Pegar as Notícias de Ubatuba
    //     $pageUbatuba = $client->request('GET', $urlUbatuba);
    //     $pageUbatuba->filter('.blog-items li')->each( function ($item){
    //         $this->resultsUbatuba[] = [
    //             'titulo' => $item->filter('h4')->text(),
    //             'content' => $item->filter('.excerpt')->text(),
    //             'url' => $item->filter('a')->attr('href'),
    //             'img' => $item->filter('img')->attr('src'),
    //             'local' => 'ubatuba'
    //         ];           
    //     });

    //     //Pegar as Notícias de Caraguatatuba
    //     $pageCaragua = $client->request('GET', $urlCaragua);
    //     $pageCaragua->filter('.card-deck .card')->each( function ($item){
    //         $this->resultsCaragua[] = [
    //             'titulo' => $item->filter('h5')->text(),
    //             'content' => $item->filter('p')->text(),
    //             'url' => $item->filter('a')->attr('href'),
    //             'img' => $item->filter('img')->attr('src'),
    //             'local' => 'caraguatatuba'
    //         ];           
    //     });

    //     //Pegar as Notícias de São Sebastião
    //     $pageSaoSeba = $client->request('GET', $urlSaoSeba);        
    //     $pageSaoSeba->filter('.notice-list-page .notice')->each( function ($item){            
    //         $this->resultsSaoSeba[] = [
    //             'titulo' => $item->filter('.notice-core h2')->text(),
    //             //'content' => $item->filter('.notice-content p')->text(),
    //             'url' => $item->filter('a')->attr('href'),
    //             //'img' => $item->filter('img')->attr('src'),
    //             //'local' => 'sao-sebastiao'
    //         ];   
    //     });

    //     //Noticia 1
    //     $pegaThumb1 = explode('/', $urlSaoSeba);
    //     $pegaThumbb1 = $pegaThumb1[0].'//'.$pegaThumb1[2].'/'.$this->resultsSaoSeba[0]['url'];
    //     $pegaThumbUrl1 = $client->request('GET', $pegaThumbb1);
    //     if(count($pegaThumbUrl1->filter('.slide')) > 0){
    //         $img1 = explode("'", $pegaThumbUrl1->filter('.slide')->attr("style"));   
    //         $img1 = $pegaThumb1[0].'//'.$pegaThumb1[2].'/'.$img1[1];         
    //     }else{
    //         $img1 = $pegaThumbUrl1->filter('.post-image img')->eq(0)->attr('src');
    //         $img1 = $pegaThumb1[0].'//'.$pegaThumb1[2].'/'.$img1;
    //     }
        
    //     //Noticia 2
    //     $pegaThumb = explode('/', $urlSaoSeba);
    //     $pegaThumbb = $pegaThumb[0].'//'.$pegaThumb[2].'/'.$this->resultsSaoSeba[1]['url'];
    //     $pegaThumbUrl = $client->request('GET', $pegaThumbb);
    //     if(count($pegaThumbUrl->filter('.slide')) > 0){
    //         $img = explode("'", $pegaThumbUrl->filter('.slide')->attr("style"));   
    //         $img = $pegaThumb[0].'//'.$pegaThumb[2].'/'.$img[1];         
    //     }else{
    //         $img = $pegaThumbUrl->filter('.post-image img')->eq(0)->attr('src');
    //         $img = $pegaThumb[0].'//'.$pegaThumb[2].'/'.$img;
    //     }
    //     $responseSSB = [
    //         [
    //             'titulo' => $this->resultsSaoSeba[0]['titulo'],
    //             'img' => $img1,
    //             'local' => 'sao-sebastiao'
    //         ],
    //         [
    //             'titulo' => $this->resultsSaoSeba[1]['titulo'],
    //             'img' => $img,
    //             'local' => 'sao-sebastiao'
    //         ]
    //     ];

    //     //Pegar as Notícias de IlhaBela
    //     $pageIlhaBela = $client->request('GET', $urlIlhaBela);
    //     $pageIlhaBela->filter('#content article')->each( function ($item){
    //         $this->resultsIlhaBela[] = [
    //             'titulo' => $item->filter('.entry-header h2')->text(),
    //             // 'content' => $item->filter('p')->text(),
    //             // 'url' => $item->filter('a')->attr('href'),
    //             'img' => $item->filter('.entry-thumbnail img')->attr('src'),
    //             // 'local' => 'ilhabela'
    //         ];           
    //     });
         
    //     $head = $this->seo->render($this->configService->getConfig()->nomedosite ?? 'Informática Livre',
    //         $this->configService->getConfig()->descricao ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
    //         route('web.home'),
    //         $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
    //     ); 
        
	// 	return view('web.home',[
    //         'head' => $head,
    //         'noticiasubatuba'  => $this->resultsUbatuba,
    //         'noticiascaragua'  => $this->resultsCaragua,
    //         'noticiassaoseba'  => $responseSSB,
    //         'noticiasilhabela' => $this->resultsIlhaBela
	// 	]);
    // }

    public function noticia($slug)
    {
        $post = Post::where('slug', $slug)->where('tipo', 'noticia')->postson()->first();
        
        $categorias = CatPost::orderBy('titulo', 'ASC')
            ->where('tipo', 'noticia')
            ->get();
        $postsMais = Post::orderBy('views', 'DESC')
            ->where('id', '!=', $post->id)
            ->where('tipo', 'noticia')
            ->limit(4)
            ->postson()
            ->get();
        
        $post->views = $post->views + 1;
        $post->save();

        $head = $this->seo->render($post->titulo ?? 'Informática Livre',
            $post->titulo,
            route('web.noticia', ['slug' => $post->slug]),
            $post->cover() ?? $this->configService->getMetaImg()
        );

        return view('web.noticia', [
            'head' => $head,
            'post' => $post,
            'postsMais' => $postsMais,
            'categorias' => $categorias
        ]);
    }

    // public function noticia($local, $categoria, $slug)
    // {        
    //     if(!empty($local)){

    //         if($local == 'ubatuba'){                
    //             $url = "https://www.ubatuba.sp.gov.br/{$categoria}/{$slug}";
    //             $page = $this->crowler->request('GET', $url);
    //             $post = [
    //                 'titulo' => $page->filter('.heading-text h1')->text(),
    //                 'data' => $page->filter('.date')->text(),
    //                 'img' => $page->filter('.page-content figure img')->attr('src'),
    //                 'content' => $page->filter('.article-body-wrap .body-text')->html(),
    //                 'fonte' => 'Prefeitura Municipal de Ubatuba',
    //                 'fontelink' => 'https://www.ubatuba.sp.gov.br'
    //             ];     
                
    //             $postMais = 'https://www.ubatuba.sp.gov.br/noticias/';
    //             $pageMais = $this->crowler->request('GET', $postMais);
    //             $pageMais->filter('.blog-items li')->each( function ($item){
    //                 $this->resultsUbatuba[] = [
    //                     'titulo' => $item->filter('h4')->text(),
    //                     'content' => $item->filter('.excerpt')->text(),
    //                     'url' => $item->filter('a')->attr('href'),
    //                     'img' => $item->filter('img')->attr('src'),
    //                     'local' => 'ubatuba'
                        
    //                 ];           
    //             });
    //         }
            
    //         return view('web.noticia',[
    //             //'head' => $head,
    //             'post' => $post,
    //             'pageMais' => $this->resultsUbatuba,
    //             'cidade' => 'ubatuba'
    //         ]);
    //     }else{
    //         //return redirect()->back();
    //     }
    // }

    public function noticiaCaragua($local, $categoria, $ano, $mes, $slug)
    {
        if(!empty($local)){
            $url = "https://www.caraguatatuba.sp.gov.br/{$categoria}/{$ano}/{$mes}/{$slug}";
            $page = $this->crowler->request('GET', $url);

            $post = [
                'titulo' => $page->filter('.card-body h5')->text(),
                'data' => $page->filter('.created-at small')->text(),
                'img' => $page->filter('.card-deck img')->attr('src'),
                'content' => $page->filter('.card-text')->html(),
                'fonte' => 'Prefeitura Municipal de Caraguatatuba',
                'fontelink' => 'https://www.caraguatatuba.sp.gov.br'
            ];  
            
            $postMais = 'https://www.caraguatatuba.sp.gov.br/pmc/category/noticias/';
            $pageMais = $this->crowler->request('GET', $postMais);
            $pageMais->filter('#latestNews .row')->each( function ($item){
                $this->resultsCaragua[] = [
                    'titulo' => $item->filter('h5')->text(),
                    'content' => $item->filter('p')->text(),
                    'url' => $item->filter('a')->attr('href'),
                    'img' => $item->filter('img')->attr('src'),
                    'data' => $item->filter('.created-at')->text(),
                    'local' => 'caraguatatuba'
                ];           
            });

            $head = $this->seo->render($post['titulo'] . ' - ' .$this->configService->getConfig()->nomedosite,
                $post['titulo'] . ' - ' .$this->configService->getConfig()->nomedosite,
                route('web.noticiaCaragua',[
                    'local' => 'caraguatatuba',
                    'categoria' => 'pmc',
                    'ano' => $ano,
                    'mes' => $mes,
                    'slug' => $slug
                ]),
                $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
            );

            return view('web.noticia',[
                'head' => $head,
                'post' => $post,
                'pageMais' => $this->resultsCaragua,
                'cidade' => 'caraguatatuba'
            ]);

        }else{
            return redirect()->back();
        }
    }

    public function quemsomos()
    {
        $projetosCount = Portifolio::count();
        $clientesCount = User::where('client', 1)->count();
        $paginaQuemSomos = Post::where('tipo', 'pagina')->postson()->where('id', 5)->first();
        $head = $this->seo->render('Quem Somos - ' . $this->configService->getConfig()->nomedosite,
            $this->configService->getConfig()->descricao ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.quemsomos'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        return view('web.quem-somos',[
            'head' => $head,
            'paginaQuemSomos' => $paginaQuemSomos,
            'projetosCount' => $projetosCount,
            'clientesCount' => $clientesCount
        ]);
    }

    public function politica()
    {
        $head = $this->seo->render('Política de Privacidade - ' . $this->configService->getConfig()->nomedosite ?? 'Informática Livre',
            'Política de Privacidade - ' . $this->configService->getConfig()->nomedosite,
            route('web.politica'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.politica',[
            'head' => $head
        ]);
    }

    public function portifolio()
    {
        $catProjetos = CatPortifolio::orderBy('created_at', 'DESC')->whereNotNull('id_pai')->available()->get(); 
        $projetos = Portifolio::orderBy('created_at', 'DESC')->available()->exibir()->get(); 
        $head = $this->seo->render('Portifólio - ' . $this->configService->getConfig()->nomedosite,
            'Confira alguns dos projetos desenvolvidos pela Informática Livre',
            route('web.portifolio'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        return view('web.portifolio',[
            'head' => $head,
            'catProjetos' => $catProjetos,
            'projetos' => $projetos
        ]);
    }

    public function projeto($slug)
    {
        $projeto = Portifolio::where('slug', $slug)->first();
        $projeto->views += 1;
        $projeto->save();
        $head = $this->seo->render($projeto->name,
            $projeto->headline ?? 'Projeto desenvolvido pela Informática Livre',
            route('web.projeto',$projeto->slug),
            $projeto->cover() ?? $this->configService->getMetaImg()
        );
        return view('web.projeto',[
            'head' => $head,
            'projeto' => $projeto
        ]);
    }

    public function orcamento()
    {
        $produtos = Produto::orderBy('valor', 'ASC')
                            ->where('categoria', 4)
                            ->exibir()
                            ->available()
                            ->get();
        $head = $this->seo->render('Soluções para sua empresa - ' . $this->configService->getConfig()->nomedosite,
            'Nossa equipe está pronta para melhor atender as demandas de nossos clientes!',
            route('web.atendimento'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );        

        return view('web.consultoria.produtos', [
            'head' => $head,
            'produtos' => $produtos            
        ]);
    }

    public function formorcamento()
    {        
        $head = $this->seo->render('Orçamento Perdonalizado - ' . $this->configService->getConfig()->nomedosite,
            'Nossa equipe está pronta para melhor atender as demandas de nossos clientes!',
            route('web.atendimento'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );        

        return view('web.consultoria.consultoria', [
            'head' => $head                       
        ]);
    }

    public function formClient($token)
    {
        $estados = Estados::orderBy('estado_nome', 'ASC')->get();
        $orcamento = Orcamento::where('token', $token)->first();
        $head = $this->seo->render('Formulário de Orçamento Perdonalizado - ' . $this->configService->getConfig()->nomedosite,
            'Nossa equipe está pronta para melhor atender as demandas de nossos clientes!',
            route('web.formClient',$token),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        return view('web.consultoria.formulario-de-retorno',[
            'head' => $head ,
            'orcamento' => $orcamento,
            'estados' => $estados
        ]);
    }

    public function artigos()
    {
        $posts = Post::orderBy('created_at', 'DESC')->where('tipo', '=', 'artigo')->postson()->paginate(10);
        $categorias = CatPost::orderBy('titulo', 'ASC')->where('tipo', 'artigo')->get();
        $head = $this->seo->render('Blog - ' . $this->configService->getConfig()->nomedosite ?? 'Informática Livre',
            'Blog - ' . $this->configService->getConfig()->nomedosite,
            route('web.blog.artigos'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        return view('web.blog.artigos', [
            'head' => $head,
            'posts' => $posts,
            'categorias' => $categorias
        ]);
    }

    public function artigo(Request $request)
    {
        $post = Post::where('slug', $request->slug)->postson()->first();
        
        $categorias = CatPost::orderBy('titulo', 'ASC')
            ->where('tipo', 'artigo')
            ->get();
        $postsMais = Post::orderBy('views', 'DESC')
            ->where('id', '!=', $post->id)
            ->where('tipo', 'artigo')
            ->limit(4)
            ->postson()
            ->get();
        
        $post->views = $post->views + 1;
        $post->save();

        $head = $this->seo->render($post->titulo ?? 'Informática Livre',
            $post->titulo,
            route('web.blog.artigo', ['slug' => $post->slug]),
            $post->cover() ?? $this->configService->getMetaImg()
        );

        return view('web.blog.artigo', [
            'head' => $head,
            'post' => $post,
            'postsMais' => $postsMais,
            'categorias' => $categorias
        ]);
    }

    public function categoria(Request $request)
    {
        $categoria = CatPost::where('slug', '=', $request->slug)->first();
        $categorias = CatPost::orderBy('titulo', 'ASC')
                    ->where('tipo', 'artigo')
                    ->where('id', '!=', $categoria->id)->get();
        $posts = Post::orderBy('created_at', 'DESC')->where('categoria', '=', $categoria->id)->postson()->paginate(10);
        
        $head = $this->seo->render($categoria->titulo . ' - Blog - ' . $this->configService->getConfig()->nomedosite ?? 'Informática Livre',
            $categoria->titulo . ' - Blog - ' . $this->configService->getConfig()->nomedosite,
            route('web.blog.categoria', ['slug' => $request->slug]),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        
        return view('web.blog.categoria', [
            'head' => $head,
            'posts' => $posts,
            'categoria' => $categoria,
            'categorias' => $categorias
        ]);
    }

    public function pesquisa(Request $request)
    {
        $search = $request->only('search');

        $paginas = Post::where(function($query) use ($request){
            if($request->search){
                $query->orWhere('titulo', 'LIKE', "%{$request->search}%")
                    ->where('tipo', 'pagina')->postson();
                $query->orWhere('content', 'LIKE', "%{$request->search}%")
                    ->where('tipo', 'pagina')->postson();
            }
        })->postson()->limit(10)->get();

        $artigos = Post::where(function($query) use ($request){
            if($request->search){
                $query->orWhere('titulo', 'LIKE', "%{$request->search}%")
                    ->where('tipo', 'artigo')->postson();
                $query->orWhere('content', 'LIKE', "%{$request->search}%")
                    ->where('tipo', 'artigo')->postson();
            }
        })->postson()->limit(10)->get();

        $projetos = Portifolio::where(function($query) use ($request){
            if($request->search){
                $query->orWhere('name', 'LIKE', "%{$request->search}%");
                $query->orWhere('content', 'LIKE', "%{$request->search}%");
            }
        })->available()->limit(10)->get();
        
        $head = $this->seo->render('Pesquisa por ' . $request->search ?? 'Informática Livre',
            'Pesquisa - ' . $this->configService->getConfig()->nomedosite,
            route('web.blog.artigos'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        
        return view('web.pesquisa',[
            'head' => $head,
            'paginas' => $paginas,
            'artigos' => $artigos,
            'projetos' => $projetos
        ]);
    }

    public function pagina($slug)
    {
        $projetosCount = Portifolio::count();
        $clientesCount = User::where('client', 1)->count();
        $post = Post::where('slug', $slug)->where('tipo', 'pagina')->postson()->first();        
        $post->views = $post->views + 1;
        $post->save();

        $head = $this->seo->render($post->titulo ?? 'Informática Livre',
            $post->titulo,
            route('web.pagina', ['slug' => $post->slug]),
            $post->cover() ?? $this->configService->getMetaImg()
        );

        return view('web.pagina', [
            'head' => $head,
            'post' => $post,
            'projetosCount' => $projetosCount,
            'clientesCount' => $clientesCount
        ]);
    }
    
    
    public function atendimento()
    {
        $head = $this->seo->render('Atendimento - ' . $this->configService->getConfig()->nomedosite,
            'Nossa equipe está pronta para melhor atender as demandas de nossos clientes!',
            route('web.atendimento'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );        

        return view('web.atendimento', [
            'head' => $head            
        ]);
    }

    

    

    // public function sendNewsletter(Request $request)
    // {
    //     if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
    //         $json = "O campo <strong>Email</strong> está vazio ou não tem um formato válido!";
    //         return response()->json(['error' => $json]);
    //     }
    //     if(!empty($request->bairro) || !empty($request->cidade)){
    //         $json = "<strong>ERRO</strong> Você está praticando SPAM!"; 
    //         return response()->json(['error' => $json]);
    //     }else{   
    //         $validaNews = Newsletter::where('email', $request->email)->first();            
    //         if(!empty($validaNews)){
    //             Newsletter::where('email', $request->email)->update(['status' => 1]);
    //             $json = "Seu e-mail já está cadastrado!"; 
    //             return response()->json(['sucess' => $json]);
    //         }else{
    //             $NewsletterCreate = Newsletter::create($request->all());
    //             $NewsletterCreate->save();
    //             $json = "Obrigado Cadastrado com sucesso!"; 
    //             return response()->json(['sucess' => $json]);
    //         }            
    //     }
    // }
}
