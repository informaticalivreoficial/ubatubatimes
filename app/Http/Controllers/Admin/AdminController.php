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
        $artigosTop = Post::orderBy('views', 'DESC')
                ->where('tipo', 'artigo')
                ->limit(6)
                ->postson()   
                ->get();                
        $totalViewsArtigos = Post::orderBy('views', 'DESC')
                ->where('tipo', 'artigo')
                ->postson()
                ->limit(6)
                ->get()
                ->sum('views');
        $noticiasTop = Post::orderBy('views', 'DESC')
                ->where('tipo', 'noticia')
                ->limit(6)
                ->postson()   
                ->get();                
        $totalViewsNoticias = Post::orderBy('views', 'DESC')
                ->where('tipo', 'noticia')
                ->postson()
                ->limit(6)
                ->get()
                ->sum('views');
        $paginasTop = Post::orderBy('views', 'DESC')
                ->where('tipo', 'pagina')
                ->limit(6)
                ->postson()   
                ->get();
        $totalViewsPaginas = Post::orderBy('views', 'DESC')
                ->where('tipo', 'pagina')
                ->postson()
                ->limit(6)
                ->get()
                ->sum('views');
        $empresasTop = Empresa::orderBy('views', 'DESC')
                ->limit(6)
                ->available()   
                ->get();
        $totalViewsEmpresas = Empresa::orderBy('views', 'DESC')
                ->available()
                ->limit(6)
                ->get()
                ->sum('views');
                
        //Notícias
        $noticiasAvailable = Post::postson()->where('tipo', 'noticia')->count();
        $noticiasUnavailable = Post::postsoff()->where('tipo', 'noticia')->count();
        //Empresas
        $empresasAvailable = Empresa::available()->count();
        $empresasUnavailable = Empresa::unavailable()->count();
        //Notícias
        $artigosAvailable = Post::postson()->where('tipo', 'artigo')->count();
        $artigosUnavailable = Post::postsoff()->where('tipo', 'artigo')->count();
        
        
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
            'noticiasTop' => $noticiasTop,
            'noticiastotalviews' => $totalViewsNoticias,
            //Artigos
            'artigosAvailable' => $artigosAvailable,
            'artigosUnavailable' => $artigosUnavailable,
            'artigosTop' => $artigosTop,
            'artigostotalviews' => $totalViewsArtigos,
            //Empresas
            'empresasAvailable' => $empresasAvailable,
            'empresasUnavailable' => $empresasUnavailable,
            'empresasTop' => $empresasTop,
            'empresastotalviews' => $totalViewsEmpresas,
            //CHART PIZZA
            'postsArtigos' => $postsArtigos,
            'postsPaginas' => $postsPaginas,
            'postsNoticias' => $postsNoticias,
            
            'paginasTop' => $paginasTop,
            'paginastotalviews' => $totalViewsPaginas,
            //Analytics
            'visitasHoje' => $visitasHoje,
            //'visitas365' => $visitas365,
            'analyticsData' => $analyticsData,
            'top_browser' => $top_browser
        ]);
    }
}
