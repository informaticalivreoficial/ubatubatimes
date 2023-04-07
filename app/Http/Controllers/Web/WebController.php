<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\{
    Anuncio,
    BoletimOndas,
    Post,
    CatPost,
    Empresa,
    PrevisaoTempo
};
use Goutte\Client;
use App\Services\ConfigService;
use App\Support\Seo;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class WebController extends Controller
{
    protected $configService;
    protected $seo;
    protected $crowler;

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
                    ->limit(4)
                    ->get();
        $noticiasCaragua = Post::orderBy('created_at', 'DESC')
                    ->where('tipo', 'noticia')
                    ->where('categoria', 16)
                    ->postson()
                    ->limit(4)
                    ->get();
        $noticiasSaoSebastiao = Post::orderBy('created_at', 'DESC')
                    ->where('tipo', 'noticia')
                    ->where('categoria', 17)
                    ->postson()
                    ->limit(4)
                    ->get();
        $noticiasIlhabela = Post::orderBy('created_at', 'DESC')
                    ->where('tipo', 'noticia')
                    ->where('categoria', 18)
                    ->postson()
                    ->limit(4)
                    ->get();
        $artigos = Post::orderBy('created_at', 'DESC')
                    ->where('tipo', 'artigo')
                    ->where('categoria', '!=', 9)
                    ->where('categoria', '!=', 7)
                    ->postson()
                    ->limit(4)
                    ->get();
        $praiasDeUbatuba = Post::orderBy('created_at', 'DESC')
                    ->where('tipo', 'artigo')
                    ->where('categoria', 9)
                    ->postson()
                    ->limit(5)
                    ->get();
        $gastronomiaDeUbatuba = Post::orderBy('created_at', 'DESC')
                    ->where('tipo', 'artigo')
                    ->where('categoria', 7)
                    ->postson()
                    ->limit(4)
                    ->get();
        
        $positionSidebarhome = Anuncio::where('posicao', 1)->available()->limit(2)->get();

        //Boletim das Ondas
        $boletim = new BoletimOndas('http://servicos.cptec.inpe.br/XML/cidade/5515/dia/0/ondas.xml');

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
            'boletim' => $boletim,
            'artigos' => $artigos,
            'praiasDeUbatuba' => $praiasDeUbatuba,
            'gastronomiaDeUbatuba' => $gastronomiaDeUbatuba,
            'positionSidebarhome' => $positionSidebarhome,
		]);
    }

    public function ondas()
    {
        $boletim = new BoletimOndas('http://servicos.cptec.inpe.br/XML/cidade/5515/dia/0/ondas.xml');
        //Anúncio
        $positionSidebarhome = Anuncio::where('posicao', 8)->available()->limit(1)->get();

        $head = $this->seo->render('Boletim das Ondas para Ubatuba' ?? 'Informática Livre',
            'Boletim das Ondas para Ubatuba' ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.ondas'),
            url(asset('frontend/assets/images/ondas.png'))
        );

        return view('web.boletim-das-ondas',[
            'head' => $head,
            'boletim' => $boletim,
            'positionSidebarhome' => $positionSidebarhome,
        ]);
    }

    public function tempo()
    {
        $boletim = new PrevisaoTempo('http://servicos.cptec.inpe.br/XML/cidade/5515/previsao.xml');

        $head = $this->seo->render('Previsão do tempo para Ubatuba' ?? 'Informática Livre',
            'Previsão do tempo para Ubatuba' ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.tempo'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        
        return view('web.previsao-do-tempo',[
            'head' => $head,
            'boletim' => $boletim->getContent(),
        ]);
    }

    public function noticia($slug)
    {
        $post = Post::where('slug', $slug)->where('tipo', 'noticia')->postson()->first();
        
        $categorias = CatPost::orderBy('titulo', 'ASC')
            ->where('tipo', 'noticia')
            ->available()
            ->whereNotNull('id_pai')
            ->get();
        $postsMais = Post::orderBy('views', 'DESC')
            ->where('id', '!=', $post->id)
            ->where('tipo', 'noticia')
            ->limit(4)
            ->postson()
            ->get();
        $postsTags = Post::orderBy('views', 'DESC')
            ->where('tipo', 'noticia')
            ->where('tags', '!=', '')
            ->where('id', '!=', $post->id)
            ->postson()
            ->limit(11)
            ->get();
        
        $post->views = $post->views + 1;
        $post->save();

        $postprevious = Post::where('id', '<', $post->id)->postson()->where('tipo', 'noticia')->first();
        $postnext = Post::where('id', '>', $post->id)->postson()->where('tipo', 'noticia')->first();

        //Anúncio
        $positionSidebarNoticia = Anuncio::where('posicao', 4)->available()->limit(2)->get();        

        $head = $this->seo->render($post->titulo ?? 'Informática Livre',
            $post->titulo,
            route('web.noticia', ['slug' => $post->slug]),
            $post->cover() ?? $this->configService->getMetaImg()
        );

        return view('web.blog.artigo', [
            'head' => $head,
            'post' => $post,
            'postsMais' => $postsMais,
            'categorias' => $categorias,
            'postsTags' => $postsTags,
            'postprevious' => $postprevious,
            'postnext' => $postnext,
            'positionSidebarNoticia' => $positionSidebarNoticia,
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

    public function artigos()
    {
        $posts = Post::orderBy('created_at', 'DESC')->where('tipo', '=', 'artigo')->postson()->paginate(21);
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

    public function noticias()
    {
        $posts = Post::orderBy('created_at', 'DESC')
                ->where('tipo', '=', 'noticia')
                ->postson()
                ->paginate(21);

        $categorias = CatPost::orderBy('titulo', 'ASC')
                ->where('tipo', 'noticia')
                ->get();
        
        $head = $this->seo->render('Notícias - ' . $this->configService->getConfig()->nomedosite ?? 'Informática Livre',
            'Notícias - ' . $this->configService->getConfig()->nomedosite,
            route('web.noticias'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.blog.artigos', [
            'head' => $head,
            'posts' => $posts,
            'categorias' => $categorias
        ]);
    }

    public function categoria($slug)
    {        
        $categoria = CatPost::where('slug', '=', $slug)->first();
        
        $type = ($categoria->tipo == 'noticia' ? 'Notícias' : 'Artigos');

        $posts = Post::orderBy('created_at', 'DESC')
                    ->where('categoria', '=', $categoria->id)
                    ->postson()
                    ->paginate(21);
        
        $head = $this->seo->render($categoria->titulo . ' - '.$type.' - ' . $this->configService->getConfig()->nomedosite ?? 'Informática Livre',
            $categoria->titulo . ' - '.$type.' - ' . $this->configService->getConfig()->nomedosite,
            route('web.blog.categoria', ['slug' => $slug ]),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        
        return view('web.blog.categoria', [
            'head' => $head,
            'posts' => $posts,
            'categoria' => $categoria,
            'type' => $type,
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

        //Anuncio
        $positionSidebarArtigo = Anuncio::where('posicao', 3)->available()->limit(2)->get();

        $head = $this->seo->render($post->titulo ?? 'Informática Livre',
            $post->titulo,
            route('web.blog.artigo', ['slug' => $post->slug]),
            $post->cover() ?? $this->configService->getMetaImg()
        );

        return view('web.blog.artigo', [
            'head' => $head,
            'post' => $post,
            'postsMais' => $postsMais,
            'categorias' => $categorias,
            'positionSidebarArtigo' => $positionSidebarArtigo,
        ]);
    }

    public function pesquisa(Request $request)
    {
        $search = $request->search;

        $resultado = [];

        $paginas = Post::where('tipo', 'pagina')
                ->where('content', 'LIKE', '%'.$search.'%')
                ->where('titulo', 'LIKE', '%'.$search.'%')
                ->postson()->limit(10)->get();

        if(!empty($paginas) && $paginas->count() > 0){
            foreach($paginas as $pagina){
                $resultPagina[] =[
                    'titulo' => $pagina->titulo,
                    'tipo' => 'Página',
                    'link' => route('web.pagina',['slug' => $pagina->slug]),
                    'desc' => $pagina->content
                ];
            } 
            $resultado = array_merge($resultado, $resultPagina);           
        }
        
        $artigos = Post::where('tipo', 'artigo')
                ->where('content', 'LIKE', '%'.$search.'%')
                ->where('titulo', 'LIKE', '%'.$search.'%')
                ->postson()->limit(10)->get();

        if(!empty($artigos) && $artigos->count() > 0){
            foreach($artigos as $artigo){
                $resultArtigo[] =[
                    'titulo' => $artigo->titulo,
                    'tipo' => 'Artigo',
                    'link' => route('web.blog.artigo',['slug' => $artigo->slug]),
                    'desc' => $artigo->content
                ];
            }   
            $resultado = array_merge($resultado, $resultArtigo);         
        }        

        $noticias = Post::where('tipo', 'noticia')
                ->where('content', 'LIKE', '%'.$search.'%')
                ->where('titulo', 'LIKE', '%'.$search.'%')
                ->postson()->limit(10)->get();

        if(!empty($noticias) && $noticias->count() > 0){
            foreach($noticias as $noticia){
                $resultNoticia[] =[
                    'titulo' => $noticia->titulo,
                    'tipo' => 'Notícia',
                    'link' => route('web.noticia',['slug' => $noticia->slug]),
                    'desc' => $noticia->content
                ];
            } 
            $resultado = array_merge($resultado, $resultNoticia);           
        }

        $empresas = Empresa::where('created_at', 'DESC')
                ->orWhere('alias_name', 'LIKE', '%'.$search.'%')
                ->orWhere('content', 'LIKE', '%'.$search.'%')
                ->available()->limit(30)->get();

        if(!empty($empresas) && $empresas->count() > 0){
            foreach($empresas as $empresa){
                $resultEmpresa[] =[
                    'titulo' => $empresa->alias_name,
                    'tipo' => 'Guia Comercial',
                    'link' => route('web.guiaEmpresa',['slug' => $empresa->slug]),
                    'desc' => $empresa->content
                ];
            }   
            $resultado = array_merge($resultado, $resultEmpresa);         
        }
        
        $head = $this->seo->render('Pesquisa por ' . $request->search ?? 'Informática Livre',
            'Pesquisa - ' . $this->configService->getConfig()->nomedosite,
            route('web.pesquisa'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        
        $data = $this->paginate($resultado);
        $data->withPath('');

        return view('web.pesquisa',[
            'head' => $head,
            'data' => $data,
            'search' => $search,
        ]);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 25, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    // public function pagina($slug)
    // {
    //     $projetosCount = Portifolio::count();
    //     $clientesCount = User::where('client', 1)->count();
    //     $post = Post::where('slug', $slug)->where('tipo', 'pagina')->postson()->first();        
    //     $post->views = $post->views + 1;
    //     $post->save();

    //     $head = $this->seo->render($post->titulo ?? 'Informática Livre',
    //         $post->titulo,
    //         route('web.pagina', ['slug' => $post->slug]),
    //         $post->cover() ?? $this->configService->getMetaImg()
    //     );

    //     return view('web.pagina', [
    //         'head' => $head,
    //         'post' => $post,
    //         'projetosCount' => $projetosCount,
    //         'clientesCount' => $clientesCount
    //     ]);
    // }
    
    
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
    
}
