<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CatPost;
use App\Models\Post;
use App\Support\Seo;
use App\Models\Config;
use App\Services\OndasService;
use App\Services\PrevisaoTempoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Analytics;
use App\Models\Company;
use Spatie\Analytics\Period;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SiteController extends Controller
{
    protected $seo, $config;

    public function __construct()
    {
        $this->seo = new Seo();
        $this->config = Config::where('id', 1)->first();
    }

    public function home()
    {        
        $todasUbatuba = Post::orderBy('created_at', 'DESC')
            ->where('type', 'noticia')
            ->where('category', 73)
            ->postson()
            ->limit(4)
            ->get();

        $noticiasUbatuba  = $todasUbatuba->take(2);   // primeiras 2
        $noticiasUbatuba1 = $todasUbatuba->skip(2);   // últimas 2

        $artigosDestaque = Post::orderBy('created_at', 'DESC')
            ->where('type', 'artigo')
            ->where('category', 81)
            ->postson()
            ->limit(1)
            ->get();

        $estradas = Post::orderBy('created_at', 'DESC')
            ->where('type', 'noticia')
            ->where('category', 77)
            ->postson()
            ->first();

        
        $noticiasCaragua = Post::orderBy('created_at', 'DESC')
                    ->where('type', 'noticia')
                    ->where('category', 74)
                    ->postson()
                    ->limit(4)
                    ->get();
        $noticiasSaoSebastiao = Post::orderBy('created_at', 'DESC')
                    ->where('type', 'noticia')
                    ->where('category', 75)
                    ->postson()
                    ->limit(4)
                    ->get();
        $noticiasIlhabela = Post::orderBy('created_at', 'DESC')
                    ->where('type', 'noticia')
                    ->where('category', 76)
                    ->postson()
                    ->limit(4)
                    ->get();
        $artigos = Post::orderBy('created_at', 'DESC')
                    ->where('type', 'artigo')
                    ->whereNotIn('category', [79, 81])
                    ->postson()
                    ->limit(8)
                    ->get();
        $praiasDeUbatuba = Post::orderBy('created_at', 'DESC')
                    ->where('type', 'artigo')
                    ->where('category', 81)
                    ->postson()
                    ->limit(5)
                    ->get();
        $gastronomiaDeUbatuba = Post::orderBy('created_at', 'DESC')
                    ->where('type', 'artigo')
                    ->where('category', 79)
                    ->postson()
                    ->limit(4)
                    ->get();
        
        // $positionSidebarhome = Anuncio::where('plan_id', 2)->available()->limit(3)->get();
        // $positionMainhome = Anuncio::where('plan_id', 9)->available()->limit(1)->get();
        // $positionFooterhome = Anuncio::where('plan_id', 5)->available()->limit(1)->get();

        
        $head = $this->seo->render($this->config->app_name ?? env('APP_NAME'),
            $this->config->information ?? env('APP_NAME'),
            route('web.home'),
            $this->config->getmetaimg() ?? url(asset('theme/images/image.jpg'))
        );
        
    	return view('web.home',[
            'head' => $head,
            'noticiasUbatuba'  => $noticiasUbatuba,
            'noticiasUbatuba1'  => $noticiasUbatuba1,
            'artigosDestaque' => $artigosDestaque,
            'estradas' => $estradas,
            'noticiasCaragua' => $noticiasCaragua,
            'noticiasSaoSebastiao' => $noticiasSaoSebastiao,
            'noticiasIlhabela' => $noticiasIlhabela,
            //'boletim' => $boletim,
            'artigos' => $artigos,
            'praiasDeUbatuba' => $praiasDeUbatuba,
            'gastronomiaDeUbatuba' => $gastronomiaDeUbatuba,
            //'positionSidebarhome' => $positionSidebarhome,
            //'positionMainhome' => $positionMainhome,
            //'positionFooterhome' => $positionFooterhome
		]);
    }

    public function ondas()
    {
        $wave = new OndasService();
        $dados = $wave->get();

        $resumo = [
            'manha' => !empty($dados['manha']) 
                ? $wave->resumo($dados['manha']) 
                : null,

            'tarde' => !empty($dados['tarde']) 
                ? $wave->resumo($dados['tarde']) 
                : null,
        ];
        //dd($dados);
        
        $head = $this->seo->render('Boletim das Ondas para Ubatuba' ?? 'Ubatuba Times',
            'Boletim das Ondas para Ubatuba' ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.ondas'),
            url('frontend/assets/images/ondas.png')
        );

        return view('web.boletim-das-ondas',[
            'head' => $head,
            'dados' => $dados,
            'resumo' => $resumo,
        ]);
    }

    public function noticia($slug)
    {
        $post = Post::where('slug', $slug)->where('type', 'noticia')->postson()->first();

        if($post == null){
            return Redirect::route('web.home');
        }
        
        $categorias = CatPost::orderBy('title', 'ASC')
            ->where('type', 'noticia')
            ->active()
            ->whereNotNull('id_pai')
            ->get();
        $postsMais = Post::orderBy('views', 'DESC')
            ->where('id', '!=', $post->id)
            ->where('type', 'noticia')
            ->limit(4)
            ->postson()
            ->get();
        $postsTags = Post::orderBy('views', 'DESC')
            ->where('type', 'noticia')
            ->where('tags', '!=', '')
            ->where('id', '!=', $post->id)
            ->postson()
            ->limit(11)
            ->get();
        
        $post->increment('views');

        $postprevious = Post::where('id', '<', $post->id)->postson()->where('type', 'noticia')->first();
        $postnext = Post::where('id', '>', $post->id)->postson()->where('type', 'noticia')->first();

        $head = $this->seo->render($post->title ?? 'Ubatuba Times',
             Str::words($post->content, 20, '...') ?? 'Informações e notícias sobre Ubatuba',
             route('web.noticia', ['slug' => $post->slug]),
             $post->cover() ?? url('theme/images/image.jpg')
        );           

        return view('web.blog.artigo', [
            'head' => $head,
            'post' => $post,
            'postsMais' => $postsMais,
            'categorias' => $categorias,
            'postsTags' => $postsTags,
            'postprevious' => $postprevious,
            'postnext' => $postnext,
        ]);
    }

    public function categoria(Request $request, $slug)
    {
        $categoria = CatPost::where('slug', '=', $slug)->first();

        $type = ($categoria->type == 'noticia' ? 'Notícias' : 'Artigos');

        $posts = Post::orderBy('created_at', 'DESC')
                    ->where('category', '=', $categoria->id)
                    ->postson()
                    ->paginate(21);

        // 🔄 requisição do scroll infinito: retorna só o HTML dos novos cards + próxima URL
        if ($request->ajax()) {
            return response()->json([
                'html'          => view('web.partials.posts-grid', ['posts' => $posts])->render(),
                'next_page_url' => $posts->nextPageUrl(),
            ]);
        }

        $categoria->increment('views');

        $head = $this->seo->render(
            $categoria->title . ' - ' . $type . ' - ' . $this->config->app_name ?? 'Ubatuba Times',
            $categoria->title . ' - ' . $type . ' - ' . $this->config->app_name,
            route('web.blog.categoria', ['slug' => $slug]),
            $this->config->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.blog.categoria', [
            'head'      => $head,
            'posts'     => $posts,
            'categoria' => $categoria,
            'type'      => $type,
        ]);
    }

    public function artigo(Request $request)
    {
        $post = Post::postson()
            ->where('slug', $request->slug)
            ->firstOrFail();

        $post->increment('views');

        $categorias = CatPost::query()
            ->where('type', 'artigo')
            ->orderBy('title')
            ->get();

        $postsMais = Post::postson()
            ->where('type', 'artigo')
            ->where('id', '!=', $post->id)
            ->orderByDesc('views')
            ->limit(4)
            ->get();

        $head = $this->seo->render(
            $post->title ?? 'Ubatuba Times',
            $post->title,
            route('web.blog.artigo', ['slug' => $post->slug]),
            $post->cover() ?? $this->config->getmetaimg()
        );

        return view('web.blog.artigo', compact(
            'head',
            'post',
            'postsMais',
            'categorias'
        ));
    }

    public function politica()
    {
        $head = $this->seo->render('Política de Privacidade - ' . $this->config->app_name ?? 'Ubatuba Times',
            'Política de Privacidade - ' . $this->config->app_name,
            route('web.politica'),
            $this->config->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.politica',[
            'head' => $head
        ]);
    }

    public function noticias(Request $request)
    {
        $posts = Post::orderBy('created_at', 'DESC')
                ->where('type', '=', 'noticia')
                ->postson()
                ->paginate(21);

        // 🔄 requisição do scroll infinito: retorna só o HTML dos novos cards + próxima URL
        if ($request->ajax()) {
            return response()->json([
                'html'          => view('web.partials.posts-grid', ['posts' => $posts])->render(),
                'next_page_url' => $posts->nextPageUrl(),
            ]);
        }

        $categorias = CatPost::orderBy('title', 'ASC')
                ->where('type', 'noticia')
                ->get();

        $head = $this->seo->render('Notícias - ' . $this->config->app_name ?? 'Ubatuba Times',
            'Notícias - ' . $this->config->app_name,
            route('web.noticias'),
            $this->config->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.blog.artigos', [
            'head' => $head,
            'posts' => $posts,
            'categorias' => $categorias,
            'type' => 'noticia'
        ]);
    }

    public function artigos()
    {
        $posts = Post::orderBy('created_at', 'DESC')->where('type', '=', 'artigo')->postson()->paginate(21);        
                
        $head = $this->seo->render('Blog - ' . $this->config->app_name ?? 'Ubatuba Times',
            'Blog - ' . $this->config->app_name,
            route('web.blog.artigos'),
            $this->config->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.blog.artigos', [
            'head' => $head,
            'posts' => $posts,
            'type' => 'artigo'
        ]);
    }

    public function tempo(PrevisaoTempoService $previsaoTempoService)
    {
        $head = $this->seo->render('Previsão do tempo para Ubatuba' ?? 'Ubatuba Times',
            'Previsão do tempo para Ubatuba' ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.tempo'),
            $this->config->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        
        return view('web.previsao-do-tempo',[
            'head' => $head,
            'boletim' => $previsaoTempoService->getBoletim(),
        ]);
    }

    public function balneabilidade()
    {
        $head = $this->seo->render('Balneabilidade das Praias' ?? 'Ubatuba Times',
            'Confira a balneabilidade das Praias de Ubatuba e Região' ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.balneabilidade'),
            asset('frontend/assets/images/balneabilidade_ubatuba_com_logo.png')
        );

        return view('web.condicao-das-praias',[
            'head' => $head,
        ]);
    }

    public function anunciar()
    {
        $labels = [];
        $visitasMensais = [];

        try {

            $analytics = cache()->remember('analytics_12_months', 60, function () {

                return Analytics::get(
                    Period::months(12),
                    metrics: ['totalUsers', 'screenPageViews'],
                    dimensions: ['yearMonth'],
                );

            });

            // 🔁 Fallback automático se não tiver dados suficientes
            if ($analytics->isEmpty()) {
                $analytics = Analytics::get(
                    Period::months(6),
                    metrics: ['totalUsers', 'screenPageViews'],
                    dimensions: ['yearMonth'],
                );
            }

            // 📅 ordena cronologicamente pelo yearMonth (formato "202506")
            // A API do GA4 não garante a ordem de retorno, então ordenamos
            // explicitamente antes de montar os arrays do gráfico.
            $analytics = $analytics
                ->filter(fn ($item) => isset($item['yearMonth']))
                ->sortBy(fn ($item) => $item['yearMonth'])
                ->values();

            foreach ($analytics as $item) {

                $mes = \Carbon\Carbon::createFromFormat('Ym', $item['yearMonth'])
                    ->translatedFormat('M');

                $labels[] = ucfirst($mes);

                $visitasMensais[] =
                    ($item['totalUsers'] ?? 0) +
                    ($item['screenPageViews'] ?? 0);
            }

        } catch (\Exception $e) {
            // 🔒 segurança total (nunca quebra a página)
            $labels = [];
            $visitasMensais = [];
        }

        $visitasTotal = array_sum($visitasMensais);

        $postsStats = [
            'artigos' => \App\Models\Post::where('type', 'artigo')->count(),
            'noticias' => \App\Models\Post::where('type', 'noticia')->count(),
        ];

        $head = $this->seo->render(
            'Anuncie Aqui - ' . $this->config->app_name,
            $this->config->information ?? 'Nossa equipe está pronta para melhor atender!',
            route('web.anunciar'),
            $this->config->getmetaimg() ?? 'https://informaticalivre.com.br/media/metaimg.jpg'
        );

        return view('web.anunciar', [
            'head' => $head,
            'visitas' => $visitasTotal,
            'labels' => $labels,
            'visitasMensais' => $visitasMensais,
            'postsStats' => $postsStats,
        ]);
    }

    public function pesquisa(Request $request)
    {
        $search = $request->search;

        // ❌ where('content', 'LIKE') AND where('title', 'LIKE') — nunca acha nada
        // ✅ deve ser OR entre content e title
        $resultado = collect();

        $tipos = [
            'pagina'  => ['type' => 'Página',   'route' => 'web.pagina'],
            'artigo'  => ['type' => 'Artigo',   'route' => 'web.blog.artigo'],
            'noticia' => ['type' => 'Notícia',  'route' => 'web.noticia'],
        ];

        foreach ($tipos as $tipo => $config) {
            Post::where('type', $tipo)
                ->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('content', 'LIKE', "%{$search}%");
                })
                ->postson()
                ->limit(10)
                ->get()
                ->each(fn ($post) => $resultado->push([
                    'title' => $post->title,
                    'type'  => $config['type'],
                    'link'  => route($config['route'], ['slug' => $post->slug]),
                    'desc'  => $post->content,
                ]));
        }

        // ❌ where('created_at', 'DESC') não faz sentido
        // ✅ orderBy + orWhere correto
        Company::orderBy('created_at', 'DESC')
            ->where(function ($q) use ($search) {
                $q->where('alias_name', 'LIKE', "%{$search}%")
                ->orWhere('content', 'LIKE', "%{$search}%");
            })
            ->available()
            ->limit(30)
            ->get()
            ->each(fn ($empresa) => $resultado->push([
                'title' => $empresa->alias_name,
                'type'  => 'Guia Comercial',
                'link'  => route('web.guiaEmpresa', ['slug' => $empresa->slug]),
                'desc'  => $empresa->content,
            ]));

        $head = $this->seo->render(
            'Pesquisa por ' . $search,
            'Pesquisa - ' . $this->config->app_name,
            route('web.pesquisa'),
            $this->config->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        $data = $this->paginate($resultado->all());
        $data->withPath('');

        return view('web.pesquisa', [
            'head'   => $head,
            'data'   => $data,
            'search' => $search,
        ]);
    }

    private function paginate(array $items, int $perPage = 10): LengthAwarePaginator
    {
        $page  = request()->get('page', 1);
        $items = Collection::make($items);

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );
    }
}
