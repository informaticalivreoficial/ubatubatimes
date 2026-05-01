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
    Configuracoes,
    Empresa,
    PrevisaoTempo
};
use Analytics;
use Spatie\Analytics\Period;
use App\Http\Controllers\Admin\PostController;
use Goutte\Client;
use App\Services\ConfigService;
use App\Support\Seo;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Redirect;

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

    
    

    

    public function noticia($slug)
    {
        $post = Post::where('slug', $slug)->where('tipo', 'noticia')->postson()->first();

        if($post == null){
            return Redirect::route('web.home');
        }
        
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

        $positionSidebarPost = Anuncio::where('plan_id', 1)->available()->limit(2)->get(); 
        $positionFooterPost = Anuncio::where('plan_id', 6)->available()->limit(1)->get();       

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
            'positionSidebarPost' => $positionSidebarPost,
            'positionFooterPost' => $positionFooterPost,
        ]);
    }
    
    

    

    
    public function artigo(Request $request)
    {
        $post = Post::where('slug', $request->slug)->postson()->first();   
        
        if($post == null){
            return Redirect::route('web.home');
        }
        
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

        //Anúncios
        $positionSidebarPost = Anuncio::where('plan_id', 4)->available()->limit(2)->get();
        $positionFooterPost = Anuncio::where('plan_id', 10)->available()->limit(1)->get();

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
            'positionSidebarPost' => $positionSidebarPost,
            'positionFooterPost' => $positionFooterPost,
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

    public function paginate($items, $perPage = 25, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    
    public function atendimento()
    {
        $head = $this->seo->render('Atendimento - ' . $this->configService->getConfig()->nomedosite,
            $this->configService->getConfig()->descricao ?? 'Nossa equipe está pronta para melhor atender as demandas de nossos clientes!',
            route('web.atendimento'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com.br/media/metaimg.jpg'
        );        

        return view('web.atendimento', [
            'head' => $head            
        ]);
    }

    public function anunciar()
    {
        $visitas365 = Analytics::get(
                Period::months(12), 
                metrics: ['totalUsers', 'sessions', 'screenPageViews'], 
                dimensions: ['month'],
        );

        $v = [];
        foreach($visitas365->all() as $key => $visitas){            
            $v[] = $visitas['totalUsers'] + $visitas['screenPageViews']; 
        }
        
        $head = $this->seo->render('Anuncie Aqui - ' . $this->configService->getConfig()->nomedosite,
            $this->configService->getConfig()->descricao ?? 'Nossa equipe está pronta para melhor atender as demandas de nossos clientes!',
            route('web.atendimento'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com.br/media/metaimg.jpg'
        ); 

        return view('web.anunciar', [
            'head' => $head,
            'visitas' => array_sum($v)            
        ]);
    }
    
}
