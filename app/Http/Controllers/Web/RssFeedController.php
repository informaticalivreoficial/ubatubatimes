<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{
    Empresa,
    Post
};
use Carbon\Carbon;

class RssFeedController extends Controller
{
    public function feed()
    {
        $posts = Post::whereDate('created_at', Carbon::today())
                ->where('tipo', 'artigo')
                ->postson()
                ->limit(10)
                ->get();
        $paginas = Post::orderBy('created_at', 'DESC')
                ->where('tipo', 'pagina')
                ->postson()
                ->limit(10)
                ->get();
        $noticias = Post::whereDate('created_at', Carbon::today())
                ->where('tipo', 'noticia')
                ->postson()
                ->limit(10)
                ->get();
        $empresas = Empresa::orderBy('views', 'DESC')
                ->orderBy('cliente', 'DESC')
                ->available()
                ->limit(50)
                ->get();
        
        return response()->view('web.feed', [
            'posts' => $posts,
            'paginas' => $paginas,
            'noticias' => $noticias,
            'empresas' => $empresas,
        ])->header('Content-Type', 'application/xml');        
    }
}
