<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Analytics;
use Spatie\Analytics\Period;
use App\Models\{
    CatPost,
    Empresa,
    //Orcamento,
    User,
    Post,
    Produto
};

class AdminController extends Controller
{
    public function home()
    {
        //Users
        $time = User::where('admin', 1)->orWhere('editor', 1)->count();
        $usersAvailable = User::where('client', 1)->available()->count();
        $usersUnavailable = User::where('client', 1)->unavailable()->count();
        //CHART PIZZA
        $postsArtigos = CatPost::where('tipo', 'artigo')->count();
        $postsPaginas = CatPost::where('tipo', 'pagina')->count();
        $postsNoticias = CatPost::where('tipo', 'noticia')->count();
        $artigosTop = Post::where(DB::raw('YEAR(created_at)'), '=', date('Y'))
                ->where('tipo', 'artigo')
                ->limit(6)
                ->postson()   
                ->get()            
                ->sortByDesc('views');                
        $totalViewsArtigos = Post::selectRaw('SUM(views) AS VIEWS')
                ->where('tipo', 'artigo')
                ->where( DB::raw('YEAR(created_at)'), '=', date('Y') )
                ->postson()
                ->first();
        $paginasTop = Post::where('tipo', 'pagina')
                ->limit(4)
                ->postson()
                ->get()
                ->sortByDesc('views');
        $totalViewsPaginas = Post::selectRaw('SUM(views) AS VIEWS')
                ->where('tipo', 'pagina')
                ->postson()
                ->first();

        //Notícias
        $noticiasAvailable = Post::postson()->where('tipo', 'noticia')->count();
        $noticiasUnavailable = Post::postsoff()->where('tipo', 'noticia')->count();
        //Notícias
        $artigosAvailable = Post::postson()->where('tipo', 'artigo')->count();
        $artigosUnavailable = Post::postsoff()->where('tipo', 'artigo')->count();
        //Roteiros Mais
        // $roteirosTop = Roteiro::where(DB::raw('YEAR(created_at)'), '=', date('Y'))
        //         ->limit(4)->available()->get()->sortByDesc('views');
        // $totalviewsroteiros = Roteiro::selectRaw('SUM(views) AS VIEWS')
        //         ->available()
        //         ->where( DB::raw('YEAR(created_at)'), '=', date('Y') )
        //         ->first();     
        
        //Analitcs
        $visitasHoje = Analytics::fetchMostVisitedPages(Period::days(1));
        $visitas365 = Analytics::fetchTotalVisitorsAndPageViews(Period::months(5));
        $top_browser = Analytics::fetchTopBrowsers(Period::months(5));

        $analyticsData = Analytics::performQuery(
            Period::months(5),
               'ga:sessions',
               [
                   'metrics' => 'ga:sessions, ga:visitors, ga:pageviews',
                   'dimensions' => 'ga:yearMonth'
               ]
         );     
         
        return view('admin.dashboard',[ 
            'time' => $time,
            'usersAvailable' => $usersAvailable,
            'usersUnavailable' => $usersUnavailable,
            //Notícias
            'noticiasAvailable' => $noticiasAvailable,
            'noticiasUnavailable' => $noticiasUnavailable,
            //Artigos
            'artigosAvailable' => $artigosAvailable,
            'artigosUnavailable' => $artigosUnavailable,
            //CHART PIZZA
            'postsArtigos' => $postsArtigos,
            'postsPaginas' => $postsPaginas,
            'postsNoticias' => $postsNoticias,
            'artigosTop' => $artigosTop,
            'artigostotalviews' => $totalViewsArtigos->VIEWS,
            'paginasTop' => $paginasTop,
            'paginastotalviews' => $totalViewsPaginas->VIEWS,
            //Analytics
            'visitasHoje' => $visitasHoje,
            //'visitas365' => $visitas365,
            'analyticsData' => $analyticsData,
            'top_browser' => $top_browser
        ]);
    }
}
