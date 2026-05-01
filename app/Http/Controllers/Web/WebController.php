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

    
    
}
